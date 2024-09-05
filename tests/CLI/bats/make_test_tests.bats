#!/usr/bin/env bats

load 'bats-support/load'
load 'bats-assert/load'

@test "make all-tests command executes" {
  run make all-tests
  assert_output --partial 'OK'
  assert_success
}

@test "make average-load-tests command executes" {
  run make average-load-tests
  assert_success
  assert_output --partial 'load metadata'
}

@test "make stress-load-tests command executes" {
  run make stress-load-tests
  assert_success
  assert_output --partial 'load metadata'
}

@test "make spike-load-tests command executes" {
  run make spike-load-tests
  assert_success
  assert_output --partial 'load metadata'
}

@test "make load-tests command executes" {
  run make load-tests
  assert_success
  assert_output --partial 'load metadata'
}

@test "make e2e-tests command executes" {
  run make e2e-tests
  assert_output --partial 'Symfony extension is correctly installed'
  assert_success
}

@test "make behat command executes" {
  run make behat
  assert_output --partial 'passed'
  assert_success
}

@test "make integration-tests command executes" {
  run make integration-tests
  assert_output --partial 'PHPUnit'
  assert_success
}

@test "make tests-with-coverage command executes" {
  run make tests-with-coverage
  assert_output --partial 'Testing'
  assert_success
}
@test "make behat command executes" {
  run make behat
  assert_output --partial 'passed'
  assert_success
}

@test "make integration-tests command executes" {
  run make integration-tests
  assert_output --partial 'PHPUnit'
  assert_success
}

@test "make tests-with-coverage command executes" {
  run make tests-with-coverage
  assert_output --partial 'Testing'
  assert_success
}
