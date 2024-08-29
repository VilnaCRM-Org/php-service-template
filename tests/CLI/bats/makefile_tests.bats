#!/usr/bin/env bats

load 'bats-support/load'
load 'bats-assert/load'

@test "make help command lists all available targets" {
  run make help
  assert_success
  assert_output --partial "Usage:"
  assert_output --partial "make [target] [arg=\"val\"...]"
  assert_output --partial "Targets:"
}

@test "make composer-validate command executes and reports validity with warnings" {
  run make composer-validate
  assert_success
  assert_output --partial "./composer.json is valid, but with a few warnings"
}

@test "make check-requirements command executes and passes" {
  run make check-requirements
  assert_success
  assert_output --partial "Symfony Requirements Checker"
  assert_output --partial "Your system is ready to run Symfony projects"
}

@test "make check-security command executes and reports no vulnerabilities" {
  run make check-security
  assert_success
  assert_output --partial "Symfony Security Check Report"
  assert_output --partial "No packages have known vulnerabilities."
}

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

@test "make infection command executes" {
  run make infection
  assert_success
  assert_output --partial 'Infection - PHP Mutation Testing Framework'
}

@test "make execute-load-tests-script command executes" {
  run make execute-load-tests-script
  assert_output --partial "true true true true"
}

@test "make doctrine-migrations-migrate executes migrations" {
  run bash -c "echo 'yes' | make doctrine-migrations-migrate"
  assert_success
  assert_output --partial 'DoctrineMigrations'
}

@test "make doctrine-migrations-generate command executes" {
  run make doctrine-migrations-generate
  assert_success
}

@test "make cache-clear command executes" {
  run make cache-clear
  assert_success
}

@test "make install command executes" {
  run make install
  assert_success
}

@test "make update command executes" {
  run make update
  assert_success
}

@test "make load-fixtures command executes" {
   run bash -c "make load-fixtures & sleep 2; kill $!"
   assert_failure
   assert_output --partial "Successfully deleted cache entries."
}

@test "make build command starts successfully and shows initial build output" {
  run timeout 5 make build
  assert_failure 124
  assert_output --partial "docker compose build --pull --no-cache"
}

@test "make cache-warmup command executes" {
  run make cache-warmup
  assert_success
}

@test "make purge command executes" {
  run make purge
  assert_success
}

@test "make logs shows docker logs" {
  run bash -c "timeout 5 make logs"
  assert_failure 124
  assert_output --partial "GET /ping" 200
}

@test "make new-logs command executes" {
  run bash -c "timeout 5 make logs"
  assert_failure 124
  assert_output --partial ""GET /ping" 200"
}

@test "make commands lists all available Symfony commands" {
  run make commands
  assert_success
  assert_output --partial "Usage:"
  assert_output --partial "command [options] [arguments]"
  assert_output --partial "Options:"
  assert_output --partial "-h, --help            Display help for the given command."
  assert_output --partial "Available commands:"

}

@test "make coverage-html command executes" {
  run make coverage-html
  assert_success
}

@test "make coverage-xml command executes" {
  run make coverage-xml
  assert_success
}

@test "make generate-openapi-spec command executes" {
  run make generate-openapi-spec
  assert_success
}

@test "make generate-graphql-spec command executes" {
  run make generate-graphql-spec
  assert_success
}

@test "make sh attempts to open a shell in the PHP container" {
  run bash -c "make sh & sleep 2; kill $!"
  assert_failure
  assert_output --partial "php-service-template"
}

@test "make stop command executes" {
  run make stop
  assert_success
}

@test "make down command executes" {
  run make down
  assert_success
}
