#!/usr/bin/env bats

load 'bats-support/load'
load 'bats-assert/load'

@test "make check-security should report vulnerabilities if present" {
  cp composer.lock composer.lock.bak

  original_content=$(cat composer.lock)

  modified_content=$(echo "$original_content" | jq '.packages += [{"name": "symfony/http-kernel", "version": "v4.4.0"}]')

  echo "$modified_content" > composer.lock

  run make check-security

  mv composer.lock.bak composer.lock

  assert_failure
  assert_output --partial "symfony/http-kernel (v4.4.0)"
  assert_output --partial "1 package has known vulnerabilities"
}

@test "make infection should fail due to partly covered class" {
  mv tests/CLI/bats/php/PartlyCoveredEventBus.php src/Shared/Infrastructure/Bus/Event/

  composer dump-autoload

  run make unit-tests
  run make infection

  mv src/Shared/Infrastructure/Bus/Event/PartlyCoveredEventBus.php tests/CLI/bats/php/

  assert_output --partial "8 mutants were not covered by tests"
}

@test "make behat should fail when scenarios fail" {
  mv tests/Behat/DemoContext.php tests/
  run make behat
  mv tests/DemoContext.php tests/Behat/
  assert_failure
}

@test "make psalm should fail when there are errors" {
  mv tests/CLI/bats/php/PsalmErrorExample.php src/Shared/Application/

  run make psalm

  mv src/Shared/Application/PsalmErrorExample.php tests/CLI/bats/php/

  assert_failure
  assert_output --partial "does not exist"
}

@test "make deptrac should fail when there are dependency violations" {
  mkdir src/CompanySubdomain/SomeModule/Domain/Entity/
  mv tests/CLI/bats/php/SomeEntity.php src/CompanySubdomain/SomeModule/Domain/Entity/

  run make deptrac

  mv src/CompanySubdomain/SomeModule/Domain/Entity/SomeEntity.php tests/CLI/bats/php/
  rmdir src/CompanySubdomain/SomeModule/Domain/Entity/
  assert_output --partial "App\CompanySubdomain\SomeModule\Domain\Entity\SomeEntity must not depend on App\CompanySubdomain\SomeModule\Application\Command\SomeCommand"
  assert_failure
}

@test "make e2e-tests should fail when scenarios fail" {
  mv tests/Behat/DemoContext.php tests/
    run make behat
    mv tests/DemoContext.php tests/Behat/
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

@test "PHP CS Fixer should report violations if present" {
  echo "<?php \$foo = 'bar' ;  " > temp_file.php
  run docker compose exec php ./vendor/bin/php-cs-fixer fix temp_file.php --dry-run --diff
  rm temp_file.php
  assert_failure
}

@test "make composer-validate should fail with invalid composer.json" {
  mv composer.json composer.json.bak
  echo "{" > composer.json

  run make composer-validate

  mv composer.json.bak composer.json

  assert_failure
  assert_output --partial "does not contain valid JSON"
}

@test "make aws-lod-tests without config should fail" {
  run make aws-load-tests
  assert_failure
}