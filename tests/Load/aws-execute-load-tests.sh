#!/bin/bash

export AWS_PAGER=""
REGION="us-east-1"
AMI_ID="ami-0e86e20dae9224db8"
INSTANCE_TYPE="t2.micro"
SECURITY_GROUP="sg-0479b7b8cd5d172e7"
INSTANCE_TAG="LoadTestInstance"

BUCKET_NAME="loadtest-bucket-$(uuidgen)"
echo "Using S3 bucket: $BUCKET_NAME"

aws s3 mb s3://$BUCKET_NAME --region $REGION
if [ $? -ne 0 ]; then
  echo "Error: Failed to create S3 bucket."
  exit 1
fi

BUCKET_POLICY=$(cat <<EOF
{
  "Version": "2012-10-17",
  "Statement": [
    {
      "Effect": "Allow",
      "Principal": {
        "AWS": "arn:aws:iam::191243910997:role/EC2S3WriteAccessRole"
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

aws s3api put-bucket-policy --bucket $BUCKET_NAME --policy file://bucket-policy.json --region $REGION
if [ $? -ne 0 ]; then
  echo "Error: Failed to apply bucket policy."
  exit 1
fi

ROLE_NAME="EC2S3WriteAccessRole"
TRUST_POLICY='{
  "Version": "2012-10-17",
  "Statement": [{"Effect": "Allow","Principal": {"Service": "ec2.amazonaws.com"},"Action": "sts:AssumeRole"}]
}'

aws iam create-role --role-name $ROLE_NAME --assume-role-policy-document "$TRUST_POLICY" --region $REGION || echo "Role already exists. Proceeding..."

ACCESS_POLICY='{
  "Version": "2012-10-17",
  "Statement": [{"Effect": "Allow","Action": ["s3:PutObject","s3:ListBucket"],"Resource": ["arn:aws:s3:::'$BUCKET_NAME'","arn:aws:s3:::'$BUCKET_NAME'/*"]}]
}'

POLICY_ARN=$(aws iam create-policy --policy-name S3WriteAccessToBucket --policy-document "$ACCESS_POLICY" --query 'Policy.Arn' --output text --region $REGION 2>/dev/null) || POLICY_ARN=$(aws iam list-policies --query "Policies[?PolicyName=='S3WriteAccessToBucket'].Arn" --output text --region $REGION)

aws iam attach-role-policy --role-name $ROLE_NAME --policy-arn $POLICY_ARN --region $REGION
if [ $? -ne 0 ]; then
  echo "Error: Failed to attach policy to role."
  exit 1
fi

aws iam create-instance-profile --instance-profile-name $ROLE_NAME --region $REGION || echo "Instance profile already exists. Proceeding..."
aws iam add-role-to-instance-profile --instance-profile-name $ROLE_NAME --role-name $ROLE_NAME --region $REGION

sleep 15

echo "Checking IAM role permissions..."
aws sts get-caller-identity
if [ $? -ne 0 ]; then
  echo "Error: Unable to validate IAM role permissions."
  exit 1
fi

USER_DATA=$(cat <<EOF
#!/bin/bash
set -e
export DEBIAN_FRONTEND=noninteractive

sudo apt-get update -y
sudo apt-get install -y docker.io git make unzip

curl "https://awscli.amazonaws.com/awscli-exe-linux-x86_64.zip" -o "awscliv2.zip"
unzip awscliv2.zip
sudo ./aws/install

sudo curl -L "https://github.com/docker/compose/releases/latest/download/docker-compose-$(uname -s)-$(uname -m)" -o /usr/local/bin/docker-compose
sudo chmod +x /usr/local/bin/docker-compose

git clone --branch main https://github.com/VilnaCRM-Org/php-service-template.git

cd php-service-template

aws s3 cp tests/Load/results/ s3://$BUCKET_NAME/$(hostname)-results/ --recursive --region $REGION
EOF
)

INSTANCE_ID=$(aws ec2 run-instances \
  --image-id $AMI_ID \
  --instance-type $INSTANCE_TYPE \
  --security-group-ids $SECURITY_GROUP \
  --region $REGION \
  --iam-instance-profile Name=$ROLE_NAME \
  --user-data "$USER_DATA" \
  --block-device-mappings '[{"DeviceName":"/dev/sda1","Ebs":{"VolumeSize":30}}]' \
  --instance-initiated-shutdown-behavior terminate \
  --tag-specifications "ResourceType=instance,Tags=[{Key=Name,Value=$INSTANCE_TAG}]" \
  --query "Instances[0].InstanceId" \
  --output text)

if [ $? -ne 0 ]; then
  echo "Error: Failed to launch EC2 instance."
  exit 1
fi

echo "Launched instance: $INSTANCE_ID"
