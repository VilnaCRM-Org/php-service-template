#!/usr/bin/env bats

load 'bats-support/load'
load 'bats-assert/load'

@test "make phpcsfixer command executes" {
  run make phpcsfixer
  assert_success
  assert_output --partial "Running analysis on 1 core sequentially."
}

@test "make phpinsights command executes and completes analysis" {
  run make phpinsights
  assert_success
  assert_output --partial '✨ Analysis Completed !'
  assert_output --partial './vendor/bin/phpinsights --no-interaction --ansi --format=github-action'
}

@test "make psalm command executes and reports no errors" {
  run make psalm
  assert_success
  assert_output --partial 'No errors found!'
}

@test "make psalm-security command executes and reports no errors" {
  run make psalm-security
  assert_success
  assert_output --partial 'No errors found!'
  assert_output --partial './vendor/bin/psalm --taint-analysis'
}

@test "make deptrac command executes and reports no violations" {
  run make deptrac
  assert_output --partial './vendor/bin/deptrac analyse'
  assert_success
}

@test "make deptrac-debug command executes" {
  run make make deptrac-debug
  assert_output --partial 'App'
  assert_success
}

@test "make unit-tests command executes" {
  run make unit-tests
  assert_output --partial 'OK'
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

@test "make e2e-tests command executes" {
  run make e2e-tests
  assert_output --partial 'Symfony extension is correctly installed'
  assert_success
}