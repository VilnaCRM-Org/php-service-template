#!/bin/bash
set -e

export $(grep -v '^#' .env | xargs)

DEFAULT_REGION="us-east-1"
DEFAULT_AMI_ID="ami-0e86e20dae9224db8"
DEFAULT_INSTANCE_TYPE="t2.micro"
DEFAULT_INSTANCE_TAG="LoadTestInstance"
DEFAULT_ROLE_NAME="EC2S3WriteAccessRole"
DEFAULT_BRANCH_NAME="main"
DEFAULT_SECURITY_GROUP_NAME="LoadTestSecurityGroup"
DEFAULT_LOCAL_MODE="false"
BUCKET_FILE='./tests/Load/bucket_name.txt'
BUCKET_NAME="loadtest-bucket-$(uuidgen)"

usage() {
  echo "Usage: $0 [-r region] [-a ami_id] [-t instance_type] [-i instance_tag] [-o role_name] [-b branch_name] [-s security_group_name] [-l local_mode]"
  exit 1
}

while getopts "r:a:t:i:o:b:s:" opt; do
    case ${opt} in
        r) REGION=${OPTARG} ;;
        a) AMI_ID=${OPTARG} ;;
        t) INSTANCE_TYPE=${OPTARG} ;;
        i) INSTANCE_TAG=${OPTARG} ;;
        o) ROLE_NAME=${OPTARG} ;;
        b) BRANCH_NAME=${OPTARG} ;;
        s) SECURITY_GROUP_NAME=${OPTARG} ;;
        *) usage ;;
    esac
done

REGION=${REGION:-$DEFAULT_REGION}
AMI_ID=${AMI_ID:-$DEFAULT_AMI_ID}
INSTANCE_TYPE=${INSTANCE_TYPE:-$DEFAULT_INSTANCE_TYPE}
INSTANCE_TAG=${INSTANCE_TAG:-$DEFAULT_INSTANCE_TAG}
ROLE_NAME=${ROLE_NAME:-$DEFAULT_ROLE_NAME}
BRANCH_NAME=${BRANCH_NAME:-$DEFAULT_BRANCH_NAME}
SECURITY_GROUP_NAME=${SECURITY_GROUP_NAME:-$DEFAULT_SECURITY_GROUP_NAME}

LOCAL_MODE=${LOCAL_MODE_ENV:-$DEFAULT_LOCAL_MODE}

if [[ "$LOCAL_MODE" == "true" ]]; then
    export ENDPOINT_URL=http://localhost:$LOCALSTACK_PORT
    export AWS_ACCESS_KEY_ID=$AWS_SQS_KEY
    export AWS_SECRET_ACCESS_KEY=$AWS_SQS_SECRET
    AWS_CLI="aws --endpoint-url=${ENDPOINT_URL}"
else
    AWS_CLI="aws"
fi

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
echo "Local Mode: $LOCAL_MODE"
