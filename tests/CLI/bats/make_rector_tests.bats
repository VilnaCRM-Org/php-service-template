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

@test "make rector ci execute" {
  run make rector-ci
  assert_success
}

@test "make rector execute" {
  run make rector
  assert_success
}
