#!/bin/bash

AMI_ID="ami-0182f373e66f89c85"
INSTANCE_TYPE="t2.xlarge"
KEY_NAME="vilnacrm"
SECURITY_GROUP="sg-0479b7b8cd5d172e7"
REGION="us-east-1"
INSTANCE_TAG="LoadTestInstance"

INSTANCE_ID=$(aws ec2 run-instances \
  --image-id $AMI_ID \
  --instance-type $INSTANCE_TYPE \
  --key-name $KEY_NAME \
  --security-group-ids $SECURITY_GROUP \
  --region $REGION \
  --tag-specifications "ResourceType=instance,Tags=[{Key=Name,Value=$INSTANCE_TAG}]" \
  --query "Instances[0].InstanceId" \
  --output text)

aws ec2 wait instance-running --instance-ids $INSTANCE_ID --region $REGION

PUBLIC_IP=$(aws ec2 describe-instances --instance-ids $INSTANCE_ID --region $REGION --query "Reservations[0].Instances[0].PublicIpAddress" --output text)

sleep 60

ssh -o StrictHostKeyChecking=no -t -i "tests/Load/$KEY_NAME.pem" ec2-user@$PUBLIC_IP << EOF
  sudo yum update -y
  sudo yum install -y git make
  git clone https://github.com/VilnaCRM-Org/php-service-template.git
  git clone https://github.com/VilnaCRM-Org/php-service-template.git
  make start
  make setup-test-db
  make load-tests
EOF

scp -o StrictHostKeyChecking=no -i "tests/Load/$KEY_NAME.pem" ec2-user@$PUBLIC_IP:/tests/Load/results/* .

aws ec2 terminate-instances --instance-ids $INSTANCE_ID --region $REGION

aws ec2 wait instance-terminated --instance-ids $INSTANCE_ID --region $REGION
