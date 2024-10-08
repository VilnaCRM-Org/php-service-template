#!/usr/bin/env bats

load 'bats-support/load'
load 'bats-assert/load'

@test "make setup-test-db works correctly" {
  run make setup-test-db
  assert_success
}

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

@test "make phpinsights command executes and completes analysis" {
  run make phpinsights
  assert_success
  assert_output --partial '✨ Analysis Completed !'
  assert_output --partial './vendor/bin/phpinsights --no-interaction --ansi --format=github-action'
}

@test "make check-security command executes and reports no vulnerabilities" {
  run make check-security
  assert_success
  assert_output --partial "Symfony Security Check Report"
  assert_output --partial "No packages have known vulnerabilities."
}

@test "make infection command executes" {
  run make infection
  assert_success
  assert_output --partial 'Infection - PHP Mutation Testing Framework'
  assert_output --partial 'Mutation Code Coverage: 100%'
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
  coverage_html_dir="coverage/html/index.html"
  [ -f "$coverage_html_dir" ]
  assert_success
}

@test "make generate-openapi-spec command executes" {
  run make generate-openapi-spec
  assert_success
  graphql_dir=".github/graphql-spec/spec"
  [ -f "$graphql_dir" ]
  assert_success
}
