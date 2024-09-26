#!/bin/bash

# config.sh
# Configuration file for environment variables

export AWS_PAGER=""
export REGION="us-east-1"
export AMI_ID="ami-0e86e20dae9224db8"
export INSTANCE_TYPE="t2.micro"
export INSTANCE_TAG="LoadTestInstance"
export ROLE_NAME="EC2S3WriteAccessRole"
export BRANCH_NAME="main"
export BUCKET_NAME="loadtest-bucket-$(uuidgen)"
export SECURITY_GROUP_NAME="LoadTestSecurityGroup"