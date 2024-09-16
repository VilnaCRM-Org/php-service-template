#!/bin/bash

AMI_ID="ami-0e86e20dae9224db8"
INSTANCE_TYPE="t2.micro"
KEY_NAME="vilnacrm"
SECURITY_GROUP="sg-0479b7b8cd5d172e7"
REGION="us-east-1"
INSTANCE_TAG="AppInstance"

INSTANCE_TAG_TESTER="LoadTestInstance"

INSTANCE_ID_APP=$(aws ec2 run-instances \
  --image-id $AMI_ID \
  --instance-type $INSTANCE_TYPE \
  --key-name $KEY_NAME \
  --security-group-ids $SECURITY_GROUP \
  --region $REGION \
  --block-device-mappings '[{"DeviceName":"/dev/sda1","Ebs":{"VolumeSize":30}}]' \
  --tag-specifications "ResourceType=instance,Tags=[{Key=Name,Value=$INSTANCE_TAG}]" \
  --query "Instances[0].InstanceId" \
  --output text)

BRANCH_NAME=$(echo "${GITHUB_REF#refs/heads/}")
if [ -z "$BRANCH_NAME" ]; then
  BRANCH_NAME="main"
fi

aws ec2 wait instance-running --instance-ids $INSTANCE_ID_APP --region $REGION

PUBLIC_IP_APP=$(aws ec2 describe-instances --instance-ids $INSTANCE_ID_APP --region $REGION --query "Reservations[0].Instances[0].PublicIpAddress" --output text)

sleep 60

ssh -o StrictHostKeyChecking=no -t -i "tests/Load/$KEY_NAME.pem" ubuntu@$PUBLIC_IP_APP << EOF
  sudo apt update
  sudo apt install -y apt-transport-https ca-certificates curl gnupg-agent software-properties-common
  curl -fsSL https://download.docker.com/linux/ubuntu/gpg | sudo apt-key add -
  sudo add-apt-repository \
  "deb [arch=amd64] https://download.docker.com/linux/ubuntu \
  \$(lsb_release -cs) \
  stable"
  sudo apt update
  sudo apt install -y docker-ce docker-ce-cli containerd.io
  sudo curl -L "https://github.com/docker/compose/releases/download/v2.0.0/docker-compose-\$(uname -s)-\$(uname -m)" -o /usr/local/bin/docker-compose
  sudo chmod +x /usr/local/bin/docker-compose

  git clone --branch $BRANCH_NAME https://github.com/VilnaCRM-Org/php-service-template.git
  cd php-service-template

  sudo apt install make
  sudo docker compose up -d php caddy database localstack
EOF

while ! nc -z $PUBLIC_IP_APP 80; do
  echo "Waiting for the app to be available..."
  sleep 5
done

echo "App is available at $PUBLIC_IP_APP:80"

INSTANCE_ID_TESTER=$(aws ec2 run-instances \
  --image-id $AMI_ID \
  --instance-type $INSTANCE_TYPE \
  --key-name $KEY_NAME \
  --security-group-ids $SECURITY_GROUP \
  --region $REGION \
  --block-device-mappings '[{"DeviceName":"/dev/sda1","Ebs":{"VolumeSize":30}}]' \
  --tag-specifications "ResourceType=instance,Tags=[{Key=Name,Value=$INSTANCE_TAG_TESTER}]" \
  --query "Instances[0].InstanceId" \
  --output text)

aws ec2 wait instance-running --instance-ids $INSTANCE_ID_TESTER --region $REGION


PUBLIC_IP_TESTER=$(aws ec2 describe-instances --instance-ids $INSTANCE_ID_TESTER --region $REGION --query "Reservations[0].Instances[0].PublicIpAddress" --output text)

sleep 60

ssh -o StrictHostKeyChecking=no -t -i "tests/Load/$KEY_NAME.pem" ubuntu@$PUBLIC_IP_TESTER << EOF
    sudo apt update
    sudo apt install -y apt-transport-https ca-certificates curl gnupg-agent software-properties-common
    curl -fsSL https://download.docker.com/linux/ubuntu/gpg | sudo apt-key add -
    sudo add-apt-repository \
    "deb [arch=amd64] https://download.docker.com/linux/ubuntu \
    \$(lsb_release -cs) \
    stable"
    sudo apt update
    sudo apt install -y docker-ce docker-ce-cli containerd.io
    sudo apt install -y jq
    git clone --branch $BRANCH_NAME https://github.com/VilnaCRM-Org/php-service-template.git
    cd php-service-template

    jq '.apiHost = "$PUBLIC_IP_APP"' tests/Load/config.json.dist > temp.json && mv temp.json tests/Load/config.json.dist
    sudo apt install make
    make smoke-load-tests

EOF

scp -o StrictHostKeyChecking=no -i "tests/Load/$KEY_NAME.pem" ubuntu@$PUBLIC_IP_TESTER:~/load-test-results/* tests/Load/results

aws ec2 terminate-instances --instance-ids $INSTANCE_ID_APP $INSTANCE_ID_TESTER --region $REGION
aws ec2 wait instance-terminated --instance-ids $INSTANCE_ID_APP $INSTANCE_ID_TESTER --region $REGION
