#!/bin/bash
set -e

if [ -f "./tests/Load/config.sh" ]; then
  . ./tests/Load/config.sh
else
  echo "Configuration file config.sh not found."
  exit 1
fi

if [ -f "$BUCKET_FILE" ]; then
    BUCKET_NAME=$(cat "$BUCKET_FILE")
    echo "Found bucket name: $BUCKET_NAME"
else
    echo "Bucket name file not found. Exiting."
    exit 1
fi

echo "Deleting S3 bucket and its contents: $BUCKET_NAME"
if aws s3 ls "s3://$BUCKET_NAME" --region "$REGION" >/dev/null 2>&1; then
    aws s3 rm "s3://$BUCKET_NAME" --recursive --region "$REGION"
    aws s3 rb "s3://$BUCKET_NAME" --region "$REGION"
    echo "S3 bucket $BUCKET_NAME deleted."
else
    echo "S3 bucket $BUCKET_NAME not found."
fi

echo "Detaching IAM role policies..."
POLICY_ARN=$(aws iam list-policies --query "Policies[?PolicyName=='S3WriteAccessToBucket'].Arn" --output text --region "$REGION")
if [ -n "$POLICY_ARN" ]; then
    aws iam detach-role-policy --role-name "$ROLE_NAME" --policy-arn "$POLICY_ARN" --region "$REGION"
    aws iam delete-policy --policy-arn "$POLICY_ARN" --region "$REGION"
    echo "Deleted policy: $POLICY_ARN"
else
    echo "Policy not found: S3WriteAccessToBucket"
fi

echo "Deleting IAM instance profile and role..."
if aws iam get-instance-profile --instance-profile-name "$ROLE_NAME" --region "$REGION" >/dev/null 2>&1; then
    aws iam remove-role-from-instance-profile --instance-profile-name "$ROLE_NAME" --role-name "$ROLE_NAME" --region "$REGION"
    aws iam delete-instance-profile --instance-profile-name "$ROLE_NAME" --region "$REGION"
fi

if aws iam get-role --role-name "$ROLE_NAME" --region "$REGION" >/dev/null 2>&1; then
    aws iam delete-role --role-name "$ROLE_NAME" --region "$REGION"
    echo "IAM role $ROLE_NAME deleted."
else
    echo "IAM role $ROLE_NAME not found."
fi

echo "Deleting security group: $SECURITY_GROUP_NAME"
SECURITY_GROUP_ID=$(aws ec2 describe-security-groups \
    --filters "Name=group-name,Values=$SECURITY_GROUP_NAME" \
    --query 'SecurityGroups[0].GroupId' --output text --region "$REGION")

if [ -n "$SECURITY_GROUP_ID" ]; then
    aws ec2 delete-security-group --group-id "$SECURITY_GROUP_ID" --region "$REGION"
    echo "Security group $SECURITY_GROUP_NAME deleted."
else
    echo "Security group $SECURITY_GROUP_NAME not found."
fi

echo "Cleanup complete!"
