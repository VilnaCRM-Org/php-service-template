#!/bin/bash
set -e
export DEBIAN_FRONTEND=noninteractive

apt-get update -y
apt-get install -y docker.io git make unzip

fallocate -l 2G /swapfile
chmod 600 /swapfile
mkswap /swapfile
swapon /swapfile
echo '/swapfile none swap sw 0 0' | tee -a /etc/fstab

curl "https://awscli.amazonaws.com/awscli-exe-linux-x86_64.zip" -o "awscliv2.zip"
unzip awscliv2.zip
./aws/install

curl -L "https://github.com/docker/compose/releases/latest/download/docker-compose-$(uname -s)-$(uname -m)" -o /usr/local/bin/docker-compose
chmod +x /usr/local/bin/docker-compose

git clone --branch "$BRANCH_NAME" https://github.com/VilnaCRM-Org/php-service-template.git

cd php-service-template

cp .env .env.local
sed -i 's/APP_ENV=dev/APP_ENV=prod/g' .env.local

docker-compose -f docker-compose.prod.yml -f docker-compose.load_test.override.yml up -d

make smoke-load-tests

aws s3 cp tests/Load/results/ "s3://$BUCKET_NAME/$(hostname)-results/" --recursive --region "$REGION"

shutdown -h now
