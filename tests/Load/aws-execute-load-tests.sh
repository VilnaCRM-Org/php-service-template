#!/bin/bash

set -e

if [ -f "./tests/Load/config.sh" ]; then
  . ./tests/Load/config.sh
else
  echo "Configuration file config.sh not found."
  exit 1
fi

export AWS_PAGER=""

VPC_ID=$(aws ec2 describe-vpcs \
  --filters "Name=isDefault,Values=true" \
  --query "Vpcs[0].VpcId" --output text --region "$REGION")

if [ "$VPC_ID" = "None" ]; then
    echo "Error: Default VPC not found in region $REGION."
    exit 1
fi

echo "Using VPC ID: $VPC_ID"

echo "Creating security group: $SECURITY_GROUP_NAME"
SECURITY_GROUP=$(aws ec2 create-security-group \
  --group-name "$SECURITY_GROUP_NAME" \
  --description "Security group for load testing" \
  --vpc-id "$VPC_ID" \
  --region "$REGION" \
  --query 'GroupId' --output text 2>/dev/null) || SECURITY_GROUP=$(aws ec2 describe-security-groups \
  --group-names "$SECURITY_GROUP_NAME" \
  --query 'SecurityGroups[0].GroupId' --output text --region "$REGION")

if ! aws s3 mb s3://"$BUCKET_NAME" --region "$REGION"; then
  echo "Error: Failed to create S3 bucket."
  exit 1
fi

TRUST_POLICY='{
  "Version": "2012-10-17",
  "Statement": [{"Effect": "Allow","Principal": {"Service": "ec2.amazonaws.com"},"Action": "sts:AssumeRole"}]
}'

aws iam create-role --role-name "$ROLE_NAME" --assume-role-policy-document "$TRUST_POLICY" --region "$REGION" 2>/dev/null || echo "Role already exists. Proceeding..."

until aws iam get-role --role-name "$ROLE_NAME" --region "$REGION" >/dev/null 2>&1; do
  echo "Waiting for IAM role to become available..."
  sleep 5
done

ACCOUNT_ID=$(aws sts get-caller-identity --query "Account" --output text --region "$REGION")
ROLE_ARN="arn:aws:iam::$ACCOUNT_ID:role/$ROLE_NAME"

BUCKET_POLICY=$(cat <<EOF
{
  "Version": "2012-10-17",
  "Statement": [
    {
      "Effect": "Allow",
      "Principal": {
        "AWS": "$ROLE_ARN"
      },
      "Action": [
        "s3:PutObject",
        "s3:GetObject",
        "s3:ListBucket"
      ],
      "Resource": [
        "arn:aws:s3:::$BUCKET_NAME",
        "arn:aws:s3:::$BUCKET_NAME/*"
      ]
    }
  ]
}
EOF
)

echo "$BUCKET_POLICY" > bucket-policy.json

if ! aws s3api put-bucket-policy --bucket "$BUCKET_NAME" --policy file://bucket-policy.json --region "$REGION"; then
  echo "Error: Failed to apply bucket policy."
  exit 1
fi

ACCESS_POLICY=$(cat <<EOF
{
  "Version": "2012-10-17",
  "Statement": [{
    "Effect": "Allow",
    "Action": ["s3:PutObject","s3:ListBucket"],
    "Resource": ["arn:aws:s3:::$BUCKET_NAME","arn:aws:s3:::$BUCKET_NAME/*"]
  }]
}
EOF
)

POLICY_ARN=$(aws iam create-policy --policy-name S3WriteAccessToBucket --policy-document "$ACCESS_POLICY" --query 'Policy.Arn' --output text --region "$REGION" 2>/dev/null) || POLICY_ARN=$(aws iam list-policies --query "Policies[?PolicyName=='S3WriteAccessToBucket'].Arn" --output text --region "$REGION")

if ! aws iam attach-role-policy --role-name "$ROLE_NAME" --policy-arn "$POLICY_ARN" --region "$REGION"; then
  echo "Error: Failed to attach policy to role."
  exit 1
fi

aws iam create-instance-profile --instance-profile-name "$ROLE_NAME" --region "$REGION" 2>/dev/null || echo "Instance profile already exists. Proceeding..."

echo "Waiting for instance profile to become available..."
until aws iam get-instance-profile --instance-profile-name "$ROLE_NAME" --region "$REGION" >/dev/null 2>&1; do
  sleep 5
done

aws iam add-role-to-instance-profile --instance-profile-name "$ROLE_NAME" --role-name "$ROLE_NAME" --region "$REGION" 2>/dev/null || echo "Role already associated with instance profile. Proceeding..."

echo "Waiting for role to be associated with the instance profile..."
until aws iam get-instance-profile --instance-profile-name "$ROLE_NAME" --region "$REGION" | grep -q "$ROLE_NAME"; do
  sleep 5
done

echo "Checking IAM role permissions..."
if ! aws sts get-caller-identity; then
  echo "Error: Unable to validate IAM role permissions."
  exit 1
fi

export BUCKET_NAME REGION BRANCH_NAME
envsubst < tests/Load/user-data.sh > /tmp/user-data.sh

INSTANCE_ID=$(aws ec2 run-instances \
  --image-id "$AMI_ID" \
  --instance-type "$INSTANCE_TYPE" \
  --security-group-ids "$SECURITY_GROUP" \
  --region "$REGION" \
  --iam-instance-profile Name="$ROLE_NAME" \
  --user-data file:///tmp/user-data.sh \
  --block-device-mappings '[{"DeviceName":"/dev/sda1","Ebs":{"VolumeSize":30}}]' \
  --instance-initiated-shutdown-behavior terminate \
  --tag-specifications "ResourceType=instance,Tags=[{Key=Name,Value='$INSTANCE_TAG'}]" \
  --query "Instances[0].InstanceId" \
  --output text)

echo "Launched instance: $INSTANCE_ID"

echo "Waiting for instance to complete the tasks... this might take a few minutes."
echo "Once the instance completes, load test results will be available in S3 bucket: $BUCKET_NAME"
