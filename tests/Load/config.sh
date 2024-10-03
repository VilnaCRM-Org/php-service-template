#!/bin/bash
set -e

prompt_for_input() {
  local prompt_message=$1
  local default_value=$2
  local user_input

  read -r -p "$prompt_message [$default_value]: " user_input
  echo "${user_input:-$default_value}"
}

export AWS_PAGER=""
export REGION=$(prompt_for_input "Enter AWS Region" "us-east-1")
export AMI_ID=$(prompt_for_input "Enter AMI ID" "ami-0e86e20dae9224db8")
export INSTANCE_TYPE=$(prompt_for_input "Enter EC2 instance type" "t2.micro")
export INSTANCE_TAG=$(prompt_for_input "Enter instance tag" "LoadTestInstance")
export ROLE_NAME=$(prompt_for_input "Enter IAM Role name" "EC2S3WriteAccessRole")
export BRANCH_NAME=$(prompt_for_input "Enter Git branch name" "main")
export BUCKET_NAME="loadtest-bucket-$(uuidgen)"
export BUCKET_FILE='./tests/Load/bucket_name.txt'
export SECURITY_GROUP_NAME=$(prompt_for_input "Enter security group name" "LoadTestSecurityGroup")

echo "Configuration complete:"
echo "Region: $REGION"
echo "AMI ID: $AMI_ID"
echo "Instance Type: $INSTANCE_TYPE"
echo "Instance Tag: $INSTANCE_TAG"
echo "IAM Role Name: $ROLE_NAME"
echo "Branch Name: $BRANCH_NAME"
echo "S3 Bucket Name: $BUCKET_NAME"
echo "Bucket File Path: $BUCKET_FILE"
echo "Security Group Name: $SECURITY_GROUP_NAME"
