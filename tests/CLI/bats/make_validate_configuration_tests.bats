#!/usr/bin/env bats

load 'bats-support/load'
load 'bats-assert/load'

@test "make help includes validate-configuration target" {
  run make help
  assert_success
  assert_output --partial "validate-configuration"
}

@test "make validate-configuration command executes" {
  run make validate-configuration
  assert_success
  assert_output --partial "Configuration Validation"
  assert_output --partial "[OK]"
}

@test "make validate-configuration fails when a locked config file is modified" {
  backup_file="$(mktemp)"
  cp -a psalm.xml "$backup_file"

  echo "<!-- bats: temporary config drift check -->" >> psalm.xml

  run make validate-configuration

  mv "$backup_file" psalm.xml

  assert_failure
  assert_output --partial "Modification of locked configuration file is not allowed: psalm.xml"
}
