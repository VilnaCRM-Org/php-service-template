#!/usr/bin/env bash

source infrastructure/docker/.env
export $(cut -d= -f1 infrastructure/docker/.env)

docker-compose \
    -f infrastructure/docker/docker-compose.yml \
    "$@"