#!/bin/bash
set -e
export DEBIAN_FRONTEND=noninteractive

# Update and install necessary packages
apt-get update -y
apt-get install -y docker.io git make unzip

# Set up swap space (optional)
fallocate -l 2G /swapfile
chmod 600 /swapfile
mkswap /swapfile
swapon /swapfile
echo '/swapfile none swap sw 0 0' | tee -a /etc/fstab

# Install AWS CLI v2
curl "https://awscli.amazonaws.com/awscli-exe-linux-x86_64.zip" -o "awscliv2.zip"
unzip awscliv2.zip
./aws/install

# Install Docker Compose
curl -L "https://github.com/docker/compose/releases/latest/download/docker-compose-$(uname -s)-$(uname -m)" -o /usr/local/bin/docker-compose
chmod +x /usr/local/bin/docker-compose

# Clone your repository
git clone --branch "$BRANCH_NAME" https://github.com/VilnaCRM-Org/php-service-template.git

# Navigate to the repository
cd php-service-template

# Start necessary services
docker-compose -f docker-compose.prod.yml -f docker-compose.prod.override.yml up -d database localstack caddy php

# Run load tests
make smoke-load-tests

# Upload results to S3
aws s3 cp tests/Load/results/ "s3://$BUCKET_NAME/$(hostname)-results/" --recursive --region "$REGION"

# Shutdown the instance
shutdown -h now
