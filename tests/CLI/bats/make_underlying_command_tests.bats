#!/usr/bin/env bats

load 'bats-support/load'
load 'bats-assert/load'

@test "make update command executes" {
  run make update
  assert_success
}

@test "make sh attempts to open a shell in the PHP container" {
  run bash -c "make sh & sleep 2; kill $!"
  assert_failure
  assert_output --partial "php-service-template"
}

@test "make build command starts successfully and shows initial build output" {
  run timeout 5 make build
  assert_failure 124
  assert_output --partial "docker compose build --pull --no-cache"
}

@test "make stop command executes" {
  run make stop
  assert_success
}

@test "make down command executes" {
  run make down
  assert_success
}
