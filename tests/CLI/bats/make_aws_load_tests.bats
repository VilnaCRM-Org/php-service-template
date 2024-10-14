#!/usr/bin/env bats

load 'bats-support/load'
load 'bats-assert/load'

@test "make aws-load-tests works correctly" {
  run LOCAL_MODE_ENV=true make aws-load-tests
  assert_output --partial "Launched instance"
  assert_output --partial "You can access the S3 bucket here"
  assert_success
}
