#!/bin/bash

AMI_ID="ami-0e86e20dae9224db8"
INSTANCE_TYPE="t2.xlarge"
KEY_NAME="vilnacrm"
SECURITY_GROUP="sg-0479b7b8cd5d172e7"
REGION="us-east-1"
INSTANCE_TAG="LoadTestInstance"
VOLUME_SIZE=50

INSTANCE_ID=$(aws ec2 run-instances \
  --image-id $AMI_ID \
  --instance-type $INSTANCE_TYPE \
  --key-name $KEY_NAME \
  --security-group-ids $SECURITY_GROUP \
  --region $REGION \
  --block-device-mappings "DeviceName=/dev/sda1,Ebs={VolumeSize=$VOLUME_SIZE}" \
  --tag-specifications "ResourceType=instance,Tags=[{Key=Name,Value=$INSTANCE_TAG}]" \
  --query "Instances[0].InstanceId" \
  --output text)

aws ec2 wait instance-running --instance-ids $INSTANCE_ID --region $REGION

PUBLIC_IP=$(aws ec2 describe-instances --instance-ids $INSTANCE_ID --region $REGION --query "Reservations[0].Instances[0].PublicIpAddress" --output text)

sleep 60

ssh -o StrictHostKeyChecking=no -t -i "tests/Load/$KEY_NAME.pem" ubuntu@$PUBLIC_IP << EOF
  sudo growpart /dev/nvme0n1 1
  sudo resize2fs /dev/nvme0n1p1

  sudo apt update
  sudo apt install -y git make docker.io
  sudo systemctl start docker
  sudo usermod -a -G docker ubuntu
  sudo curl -L "https://github.com/docker/compose/releases/download/v2.12.2/docker-compose-\$(uname -s)-\$(uname -m)" -o /usr/local/bin/docker-compose
  sudo chmod +x /usr/local/bin/docker-compose
  sudo ln -s /usr/local/bin/docker-compose /usr/bin/docker-compose
  newgrp docker

  git clone https://github.com/VilnaCRM-Org/php-service-template.git
  cd php-service-template

  docker-compose up -d
  make setup-test-db
  make load-tests
EOF

scp -o StrictHostKeyChecking=no -i "tests/Load/$KEY_NAME.pem" ubuntu@$PUBLIC_IP:php-service-template/tests/Load/results/* .

aws ec2 terminate-instances --instance-ids $INSTANCE_ID --region $REGION
aws ec2 wait instance-terminated --instance-ids $INSTANCE_ID --region $REGION
