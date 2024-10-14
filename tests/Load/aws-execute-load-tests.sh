#!/bin/bash
set -e

if [ -f "./tests/Load/config.sh" ]; then
  . ./tests/Load/config.sh
else
  echo "Configuration file config.sh not found."
  exit 1
fi

export AWS_PAGER=""

VPC_ID=$($AWS_CLI ec2 describe-vpcs \
  --filters "Name=isDefault,Values=true" \
  --query "Vpcs[0].VpcId" --output text --region "$REGION")

if [ "$VPC_ID" = "None" ]; then
    echo "Error: Default VPC not found in region $REGION."
    exit 1
fi

echo "Using VPC ID: $VPC_ID"

echo "Creating security group: $SECURITY_GROUP_NAME"
SECURITY_GROUP=$($AWS_CLI ec2 create-security-group \
  --group-name "$SECURITY_GROUP_NAME" \
  --description "Security group for load testing" \
  --vpc-id "$VPC_ID" \
  --region "$REGION" \
  --query 'GroupId' --output text 2>/dev/null) || SECURITY_GROUP=$($AWS_CLI ec2 describe-security-groups \
  --group-names "$SECURITY_GROUP_NAME" \
  --query 'SecurityGroups[0].GroupId' --output text --region "$REGION")

if ! $AWS_CLI s3 mb s3://"$BUCKET_NAME" --region "$REGION"; then
  echo "Error: Failed to create S3 bucket."
  exit 1
fi

if [ -f "$BUCKET_FILE" ]; then
    rm "$BUCKET_FILE"
fi

echo "$BUCKET_NAME" > "$BUCKET_FILE"
echo "Bucket name saved to $BUCKET_FILE"

if ! $AWS_CLI iam create-role --role-name "$ROLE_NAME" --assume-role-policy-document file://tests/Load/trust-policy.json --region "$REGION" 2>/dev/null; then
    echo "Role already exists. Proceeding..."
fi

until $AWS_CLI iam get-role --role-name "$ROLE_NAME" --region "$REGION" >/dev/null 2>&1; do
  echo "Waiting for IAM role to become available..."
  sleep 5
done

ACCOUNT_ID=$($AWS_CLI sts get-caller-identity --query "Account" --output text --region "$REGION")

export BUCKET_NAME REGION ACCOUNT_ID ROLE_NAME
envsubst < tests/Load/s3-bucket-policy.json > /tmp/s3-bucket-policy-filled.json

MAX_RETRIES=53
RETRY_COUNT=0
SUCCESS=0

echo "Applying bucket policy to $BUCKET_NAME..."

while [ $RETRY_COUNT -lt $MAX_RETRIES ]; do
  if $AWS_CLI s3api put-bucket-policy --bucket "$BUCKET_NAME" --policy file:///tmp/s3-bucket-policy-filled.json --region "$REGION"; then
    SUCCESS=1
    break
  else
    echo "Failed to apply bucket policy. Retrying in 5 seconds... (Attempt $((RETRY_COUNT+1))/$MAX_RETRIES)"
    sleep 5
    RETRY_COUNT=$((RETRY_COUNT+1))
  fi
done

if [ $SUCCESS -ne 1 ]; then
  echo "Error: Failed to apply bucket policy after $MAX_RETRIES attempts."
  exit 1
else
  echo "Bucket policy applied successfully."
fi

ACCESS_POLICY_FILE="tests/Load/s3-access-policy.json"

POLICY_ARN=$($AWS_CLI iam create-policy --policy-name S3WriteAccessToBucket --policy-document file://"$ACCESS_POLICY_FILE" --query 'Policy.Arn' --output text --region "$REGION" 2>/dev/null) || POLICY_ARN=$($AWS_CLI iam list-policies --query "Policies[?PolicyName=='S3WriteAccessToBucket'].Arn" --output text --region "$REGION")

if ! $AWS_CLI iam attach-role-policy --role-name "$ROLE_NAME" --policy-arn "$POLICY_ARN" --region "$REGION"; then
  echo "Error: Failed to attach policy to role."
  exit 1
fi

$AWS_CLI iam create-instance-profile --instance-profile-name "$ROLE_NAME" --region "$REGION" 2>/dev/null || echo "Instance profile already exists. Proceeding..."

echo "Waiting for instance profile to become available..."
until $AWS_CLI iam get-instance-profile --instance-profile-name "$ROLE_NAME" --region "$REGION" >/dev/null 2>&1; do
  sleep 5
done

$AWS_CLI iam add-role-to-instance-profile --instance-profile-name "$ROLE_NAME" --role-name "$ROLE_NAME" --region "$REGION" 2>/dev/null || echo "Role already associated with instance profile. Proceeding..."

echo "Waiting for role to be associated with the instance profile..."
until $AWS_CLI iam get-instance-profile --instance-profile-name "$ROLE_NAME" --region "$REGION" | grep -q "$ROLE_NAME"; do
  sleep 5
done

echo "Checking IAM role permissions..."
if ! $AWS_CLI sts get-caller-identity --query "Account" --output text --region "$REGION"; then
  echo "Error: Unable to validate IAM role permissions."
  exit 1
fi

export BUCKET_NAME REGION BRANCH_NAME
envsubst < tests/Load/user-data.sh > /tmp/user-data.sh

INSTANCE_ID=$($AWS_CLI ec2 run-instances \
  --image-id "$AMI_ID" \
  --instance-type "$INSTANCE_TYPE" \
  --security-group-ids "$SECURITY_GROUP" \
  --region "$REGION" \
  --iam-instance-profile Name="$ROLE_NAME" \
  --user-data file:///tmp/user-data.sh \
  --block-device-mappings '[{"DeviceName":"/dev/sda1","Ebs":{"VolumeSize":30}}]' \
  --instance-initiated-shutdown-behavior terminate \
  --tag-specifications "ResourceType=instance,Tags=[{Key=Name,Value=$INSTANCE_TAG}]" \
  --query "Instances[0].InstanceId" \
  --output text)

if [ -z "$INSTANCE_ID" ]; then
  echo "Error: Failed to launch EC2 instance."
  exit 1
fi

echo "Launched instance: $INSTANCE_ID"

S3_URL="https://$REGION.console.aws.amazon.com/s3/buckets/$BUCKET_NAME?region=$REGION&bucketType=general"
echo "You can access the S3 bucket here: $S3_URL"
echo "Waiting for instance to complete the tasks... this might take a few minutes."
