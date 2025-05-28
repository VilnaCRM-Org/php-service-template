#!/usr/bin/env bats

load 'bats-support/load'
load 'bats-assert/load'

@test "make rector execute" {
  run make rector-ci
  assert_success
  assert_output --partial 'Rector is done'
}

@test "make rector-apply execute" {
  RECTOR_MODE=ci run ./vendor/bin/rector process --dry-run
  assert_output --partial 'files would have been changed (dry-run) by Rector'
}