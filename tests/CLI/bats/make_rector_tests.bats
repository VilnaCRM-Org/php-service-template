#!/usr/bin/env bats

load 'bats-support/load'
load 'bats-assert/load'

setup() {
  TMP_DIR=$(mktemp -d)
  if [ $? -ne 0 ]; then
    echo "Failed to create temporary directory"
    return 1
  fi
  cp -r src tests bin config templates Makefile rector.php .env.test "$TMP_DIR"/
  if [ $? -ne 0 ]; then
    echo "Failed to copy project files to temporary directory"
    return 1
  fi
  cd "$TMP_DIR"
}

teardown() {
  cd $BATS_TEST_DIRNAME
  rm -rf "$TMP_DIR"
}

@test "make rector execute" {
  run make rector-ci
  assert_success
}

@test "make rector-apply execute" {
  run make rector-apply
  assert_success
}