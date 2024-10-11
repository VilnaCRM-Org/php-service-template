#!/usr/bin/env bats

load 'bats-support/load'
load 'bats-assert/load'

@test "make aws-load-tests works correctly" {
  run make aws-load-tests LOCAL_MODE=true
  assert_output --partial "Launched instance"
  assert_output --partial "You can access the S3 bucket here"
  assert_success
}
