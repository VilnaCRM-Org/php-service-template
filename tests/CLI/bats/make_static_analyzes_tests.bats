#!/usr/bin/env bats

load 'bats-support/load'
load 'bats-assert/load'

setup() {
  TMP_DIR=$(mktemp -d)
  cp -r src tests bin config templates Makefile rector.php .env.test "$TMP_DIR"/
  cd "$TMP_DIR"
}

teardown() {
  rm -rf "$TMP_DIR"
}

@test "make phpcsfixer command executes" {
  run make phpcsfixer
  assert_success
  assert_output --partial "Running analysis on 1 core sequentially."
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
  run make deptrac-debug
  assert_output --partial 'App'
  assert_success
}

@test "make rector ci execute" {
  run make rector-ci
  assert_success
}

@test "make rector execute" {
  run make rector
  assert_success
}
