#!/usr/bin/env bats

load 'bats-support/load'
load 'bats-assert/load'

@test "make rector execute" {
  run make rector-ci
  assert_success
}
