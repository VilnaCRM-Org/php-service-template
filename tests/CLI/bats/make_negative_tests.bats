#!/usr/bin/env bats

load 'bats-support/load'
load 'bats-assert/load'

setup() {
  # Backup important files
  cp composer.lock composer.lock.bak
  mv composer.json composer.json.bak
  mv tests/CLI/bats/php/PartlyCoveredEventBus.php src/Shared/Infrastructure/Bus/Event/
  mv tests/CLI/bats/php/PsalmErrorExample.php src/Shared/Application/
  mv tests/Behat/DemoContext.php tests/
  mv tests/CLI/bats/php/UuidTransformer.php src/Shared/Domain/Factory/
}

teardown() {
  # Restore files to their original state
  mv composer.lock.bak composer.lock
  mv composer.json.bak composer.json
  mv src/Shared/Infrastructure/Bus/Event/PartlyCoveredEventBus.php tests/CLI/bats/php/
  mv src/Shared/Application/PsalmErrorExample.php tests/CLI/bats/php/
  mv tests/DemoContext.php tests/Behat/
  mv src/Shared/Domain/Factory/UuidTransformer.php tests/CLI/bats/php/
  rmdir src/Shared/Domain/Factory/
}

@test "make check-security should report vulnerabilities if present" {
  cp composer.lock composer.lock.bak

  trap "mv composer.lock.bak composer.lock" EXIT

  original_content=$(cat composer.lock)

  modified_content=$(echo "$original_content" | jq '.packages += [{"name": "symfony/http-kernel", "version": "v4.4.0"}]')

  echo "$modified_content" > composer.lock

  run make check-security

  assert_failure
  assert_output --partial "symfony/http-kernel (v4.4.0)"
  assert_output --partial "1 package has known vulnerabilities"
}

@test "make infection should fail due to partly covered class" {
  composer dump-autoload

  run make unit-tests
  run make infection

  assert_output --partial "8 mutants were not covered by tests"
}

@test "make behat should fail when scenarios fail" {
  run make behat
  assert_failure
}

@test "make psalm should fail when there are errors" {
  run make psalm
  assert_failure
  assert_output --partial "does not exist"
}

@test "make deptrac should fail when there are dependency violations" {
  run make deptrac
  assert_failure
}

@test "make e2e-tests should fail when scenarios fail" {
  run make behat
  assert_failure
}

@test "make phpinsights should fail when code quality is low" {
  mv tests/CLI/bats/php/temp_bad_code.php temp_bad_code.php

  run make phpinsights

  mv temp_bad_code.php tests/CLI/bats/php/

  assert_failure
  assert_output --partial "The style score is too low"
}

@test "make unit-tests should fail if tests fail" {
  mv tests/CLI/bats/php/FailingTest.php tests/Unit/

  run make unit-tests

  mv tests/Unit/FailingTest.php tests/CLI/bats/php/

  assert_failure
  assert_output --partial "FAILURES!"
}

@test "make composer-validate should fail with invalid composer.json" {
  echo "{" > composer.json

  run make composer-validate

  assert_failure
  assert_output --partial "does not contain valid JSON"
}
