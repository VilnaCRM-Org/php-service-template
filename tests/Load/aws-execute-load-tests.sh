#!/bin/bash

export AWS_PAGER=""

AMI_ID="ami-0e86e20dae9224db8"
INSTANCE_TYPE="t2.micro"
SECURITY_GROUP="sg-0479b7b8cd5d172e7"
REGION="us-east-1"
INSTANCE_TAG="LoadTestInstance"

BUCKET_NAME="your-preferred-bucket-name"

echo "Using S3 bucket: $BUCKET_NAME"

if aws s3 ls "s3://$BUCKET_NAME" 2>&1 | grep -q 'NoSuchBucket'; then
  echo "Bucket does not exist. Creating bucket: $BUCKET_NAME"
  aws s3 mb s3://$BUCKET_NAME --region $REGION
else
  echo "Bucket already exists. Proceeding..."
fi

ROLE_NAME="EC2S3WriteAccessRole"
TRUST_POLICY=$(cat <<EOF
{
  "Version": "2012-10-17",
  "Statement": [
    {
      "Effect": "Allow",
      "Principal": {
        "Service": "ec2.amazonaws.com"
      },
      "Action": "sts:AssumeRole"
    }
  ]
}
EOF
)

echo "Creating IAM role: $ROLE_NAME"

aws iam create-role --role-name $ROLE_NAME --assume-role-policy-document "$TRUST_POLICY" --region $REGION || echo "Role already exists. Proceeding..."

ACCESS_POLICY=$(cat <<EOF
{
  "Version": "2012-10-17",
  "Statement": [
    {
      "Effect": "Allow",
      "Action": [
        "s3:PutObject",
        "s3:PutObjectAcl",
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

echo "Creating IAM policy"

POLICY_ARN=$(aws iam create-policy --policy-name S3WriteAccessToBucket --policy-document "$ACCESS_POLICY" --query 'Policy.Arn' --output text --region $REGION 2>/dev/null) || POLICY_ARN=$(aws iam list-policies --query "Policies[?PolicyName=='S3WriteAccessToBucket'].Arn" --output text --region $REGION)

echo "Attaching policy to role"

aws iam attach-role-policy --role-name $ROLE_NAME --policy-arn $POLICY_ARN --region $REGION

echo "Creating instance profile"

aws iam create-instance-profile --instance-profile-name $ROLE_NAME --region $REGION || echo "Instance profile already exists. Proceeding..."

echo "Adding role to instance profile"

aws iam add-role-to-instance-profile --instance-profile-name $ROLE_NAME --role-name $ROLE_NAME --region $REGION || echo "Role already added to instance profile. Proceeding..."

echo "Waiting for instance profile to become available..."
sleep 15

BRANCH_NAME="main"

USER_DATA=$(cat <<EOF
#!/bin/bash
set -e
export DEBIAN_FRONTEND=noninteractive

sudo apt-get update -y
sudo apt-get install -y \
    apt-transport-https \
    ca-certificates \
    curl \
    gnupg-agent \
    software-properties-common \
    git \
    make \
    unzip

curl -fsSL https://download.docker.com/linux/ubuntu/gpg | sudo apt-key add -

sudo add-apt-repository \
    "deb [arch=amd64] https://download.docker.com/linux/ubuntu \
    $(lsb_release -cs) \
    stable"

sudo apt-get update -y

sudo apt-get install -y docker-ce docker-ce-cli containerd.io

sudo curl -L "https://github.com/docker/compose/releases/download/v2.0.0/docker-compose-$(uname -s)-$(uname -m)" \
    -o /usr/local/bin/docker-compose
sudo chmod +x /usr/local/bin/docker-compose

curl "https://awscli.amazonaws.com/awscli-exe-linux-x86_64.zip" -o "awscliv2.zip"
unzip awscliv2.zip
sudo ./aws/install

rm -rf awscliv2.zip aws/

git clone --branch $BRANCH_NAME https://github.com/VilnaCRM-Org/php-service-template.git
cd php-service-template

sudo docker compose up -d php caddy database localstack

make smoke-load-tests

aws s3 cp tests/Load/results/ s3://$BUCKET_NAME/$(hostname)-results/ --recursive --region $REGION

sudo shutdown -h now


EOF
)

USER_DATA_BASE64=$(echo "$USER_DATA" | base64)

echo "Launching EC2 instance"

INSTANCE_ID=$(aws ec2 run-instances \
  --image-id $AMI_ID \
  --instance-type $INSTANCE_TYPE \
  --security-group-ids $SECURITY_GROUP \
  --region $REGION \
  --block-device-mappings '[{"DeviceName":"/dev/sda1","Ebs":{"VolumeSize":30}}]' \
  --iam-instance-profile Name=$ROLE_NAME \
  --tag-specifications "ResourceType=instance,Tags=[{Key=Name,Value=$INSTANCE_TAG}]" \
  --user-data "$USER_DATA" \
  --instance-initiated-shutdown-behavior terminate \
  --query "Instances[0].InstanceId" \
  --output text)

echo "Launched instance: $INSTANCE_ID"

echo "Instance is running tasks. Results will be uploaded to S3 bucket: $BUCKET_NAME"

echo "You can retrieve the results later from the S3 bucket."

echo "Script completed."
