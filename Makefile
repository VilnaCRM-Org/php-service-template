# Load environment variables from .env.test
include .env.test

# Parameters
PROJECT       = php-service-template
GIT_AUTHOR    = Kravalg

# Executables: local only
SYMFONY_BIN   = symfony
DOCKER        = docker
DOCKER_COMPOSE = docker compose
DOCKER_COMPOSE_LOAD_TEST = $(DOCKER_COMPOSE) -f docker-compose.prod.yml -f docker-compose.load_test.override.yml
SCHEMATHESIS_IMAGE = schemathesis/schemathesis@sha256:85b0aa2937cae6de1c12d4c5d05cba59827d64d864e31afc9d645b140c64a55f
SCHEMATHESIS_URL ?= http://localhost:8081

# Executables
EXEC_PHP      = $(DOCKER_COMPOSE) exec php
COMPOSER      = $(EXEC_PHP) composer
GIT           = git
EXEC_PHP_TEST_ENV = $(DOCKER_COMPOSE) exec -e APP_ENV=test php
EXEC_PHP_LOAD_TEST_ENV = $(DOCKER_COMPOSE_LOAD_TEST) exec -e APP_ENV=prod php

# Alias
SYMFONY       = $(EXEC_PHP) bin/console
SYMFONY_TEST_ENV = $(EXEC_PHP_TEST_ENV) bin/console
SYMFONY_LOAD_TEST_ENV = $(EXEC_PHP_LOAD_TEST_ENV) bin/console

# Executables: vendors
BEHAT         = ./vendor/bin/behat
PHPUNIT       = ./vendor/bin/phpunit
PSALM         = ./vendor/bin/psalm
PHP_CS_FIXER  = ./vendor/bin/php-cs-fixer
PHPMD         = ./vendor/bin/phpmd
DEPTRAC       = ./vendor/bin/deptrac
INFECTION     = ./vendor/bin/infection
RECTOR        = ./vendor/bin/rector

# Misc
.DEFAULT_GOAL = help
.RECIPEPREFIX +=
.PHONY: $(filter-out vendor node_modules,$(MAKECMDGOALS))
.PHONY: all clean test

all: ci
clean: purge
test: all-tests

# Conditional execution based on CI environment variable
EXEC_ENV ?= $(EXEC_PHP_TEST_ENV)
ifeq ($(CI),1)
  EXEC_ENV =
endif

# Variables for environment and commands
FIXER_ENV = PHP_CS_FIXER_IGNORE_ENV=1
PHP_CS_FIXER_CMD = php ./vendor/bin/php-cs-fixer fix $(git ls-files -om --exclude-standard) --allow-risky=yes --config .php-cs-fixer.dist.php
COVERAGE_CMD = php -d memory_limit=-1 ./vendor/bin/phpunit --coverage-clover /coverage/coverage.xml
GITHUB_HOST ?= github.com
FORMAT ?= markdown

define DOCKER_EXEC_WITH_ENV
$(DOCKER_COMPOSE) exec -e $(1) php $(2)
endef

# Conditional execution based on CI environment variable
ifeq ($(CI),1)
    RUN_PHP_CS_FIXER = $(FIXER_ENV) $(PHP_CS_FIXER_CMD)
    RUN_TESTS_COVERAGE = XDEBUG_MODE=coverage $(COVERAGE_CMD)
else
    RUN_PHP_CS_FIXER = $(call DOCKER_EXEC_WITH_ENV,$(FIXER_ENV),$(PHP_CS_FIXER_CMD))
    RUN_TESTS_COVERAGE = $(call DOCKER_EXEC_WITH_ENV,APP_ENV=test -e XDEBUG_MODE=coverage,$(COVERAGE_CMD))
endif

help:
	@printf "\033[33mUsage:\033[0m\n  make [target] [arg=\"val\"...]\n\n\033[33mTargets:\033[0m\n"
	@grep -h -E '^[-a-zA-Z0-9_\.\/]+:.*?## .*$$' $(MAKEFILE_LIST) | sort | awk 'BEGIN {FS = ":.*?## "}; {printf "  \033[32m%-15s\033[0m %s\n", $$1, $$2}'

bats: ## Run tests for bash commands
	bats tests/CLI/bats/

phpcsfixer: ## A tool to automatically fix PHP Coding Standards issues
	$(RUN_PHP_CS_FIXER)

composer-validate: ## The validate command validates a given composer.json and composer.lock
	$(COMPOSER) validate

check-requirements: ## Checks requirements for running Symfony and gives useful recommendations to optimize PHP for Symfony.
	$(EXEC_ENV) $(SYMFONY_BIN) check:requirements

check-security: ## Checks security issues in project dependencies. Without arguments, it looks for a "composer.lock" file in the current directory. Pass it explicitly to check a specific "composer.lock" file.
	$(EXEC_ENV) $(SYMFONY_BIN) security:check

psalm: ## A static analysis tool for finding errors in PHP applications
	$(EXEC_ENV) $(PSALM)

psalm-security: ## Psalm security analysis
	$(EXEC_ENV) $(PSALM) --taint-analysis

psalm-security-sarif: ## Psalm security analysis with SARIF output
	$(EXEC_ENV) $(PSALM) --taint-analysis --report=results.sarif

phpmd: ## Instant PHP MD quality checks for source and test code
	$(EXEC_ENV) $(PHPMD) src ansi codesize,design,cleancode --exclude vendor
	$(EXEC_ENV) $(PHPMD) tests ansi phpmd.tests.xml --exclude vendor,tests/CLI/bats/php

phpinsights: ## Instant PHP quality checks and static analysis tool
	$(EXEC_ENV) ./vendor/bin/phpinsights --no-interaction --ansi --format=github-action --disable-security-check
	$(EXEC_ENV) ./vendor/bin/phpinsights analyse tests --no-interaction

unit-tests: ## Run unit tests
	$(EXEC_ENV) $(PHPUNIT) --testsuite=Unit

deptrac: ## Check directory structure
	$(EXEC_ENV) $(DEPTRAC) analyse --config-file=deptrac.yaml --report-uncovered --fail-on-uncovered

deptrac-debug: ## Find files unassigned for Deptrac
	$(EXEC_ENV) $(DEPTRAC) debug:unassigned --config-file=deptrac.yaml

behat: ## A php framework for autotesting business expectations
	$(EXEC_ENV) $(BEHAT)

rector-apply: ## Apply Rector transformations to the codebase
	$(EXEC_ENV) env RECTOR_MODE=dev $(RECTOR) process --ansi --config=rector.php

rector-ci: ## Run Rector in CI mode (dry-run, no diffs)
	$(EXEC_ENV) $(RECTOR) process --dry-run --ansi --no-progress-bar --no-diffs --config=rector.php

integration-tests: ## Run integration tests
	$(EXEC_ENV) $(PHPUNIT) --testsuite=Integration

tests-with-coverage: ## Run tests with coverage
	$(RUN_TESTS_COVERAGE)

define SETUP_DB
	$(1) cache:clear --no-warmup
	$(1) doctrine:database:drop --force --if-exists
	$(1) doctrine:database:create
	$(1) doctrine:migrations:migrate --no-interaction
endef

setup-test-db: ## Create database for testing purposes
	$(call SETUP_DB,$(SYMFONY_TEST_ENV))

setup-load-test-db: ## Create database for the isolated load-test stack
	$(call SETUP_DB,$(SYMFONY_LOAD_TEST_ENV))

all-tests: unit-tests integration-tests behat ## Run unit, integration and e2e tests

define RUN_LOAD_TEST
	@set -e; \
	$(DOCKER_COMPOSE_LOAD_TEST) up --build --detach --wait php database localstack; \
	trap '$(DOCKER_COMPOSE_LOAD_TEST) down --remove-orphans' EXIT; \
	$(MAKE) setup-load-test-db; \
	$(1)
endef

smoke-load-tests: build-k6-docker ## Run load tests with minimal load
	$(call RUN_LOAD_TEST,tests/Load/run-smoke-load-tests.sh)

average-load-tests: build-k6-docker ## Run load tests with average load
	$(call RUN_LOAD_TEST,tests/Load/run-average-load-tests.sh)

stress-load-tests: build-k6-docker ## Run load tests with high load
	$(call RUN_LOAD_TEST,tests/Load/run-stress-load-tests.sh)

spike-load-tests: build-k6-docker ## Run load tests with a spike of extreme load
	$(call RUN_LOAD_TEST,tests/Load/run-spike-load-tests.sh)

load-tests: build-k6-docker ## Run load tests
	$(call RUN_LOAD_TEST,tests/Load/run-load-tests.sh)

build-k6-docker:
	$(DOCKER) build -t k6 -f ./tests/Load/Dockerfile .

build-spectral-docker:
	$(DOCKER) build -t php-service-template-spectral -f ./docker/spectral/Dockerfile .

infection: ## Run mutations test.
	$(EXEC_ENV) php -d memory_limit=-1 $(INFECTION) --test-framework-options="--testsuite=Unit" --show-mutations -j8

execute-load-tests-script: build-k6-docker ## Execute single load test scenario.
	tests/Load/execute-load-test.sh $(scenario) $(or $(runSmoke),true) $(or $(runAverage),true) $(or $(runStress),true) $(or $(runSpike),true)

doctrine-migrations-migrate: ## Executes a migration to a specified version or the latest available version
	$(SYMFONY) d:m:m

doctrine-migrations-generate: ## Generates a blank migration class
	$(SYMFONY) d:m:g

cache-clear: ## Clears and warms up the application cache for a given environment and debug mode
	$(SYMFONY) c:c

install: composer.lock ## Install vendors according to the current composer.lock file
	@$(COMPOSER) install --no-progress --prefer-dist --optimize-autoloader

update: ## Update vendors according to the current composer.json file
	@$(COMPOSER) update --no-progress --prefer-dist --optimize-autoloader

cache-warmup: ## Warmup the Symfony cache
	@$(SYMFONY) cache:warmup

purge: ## Purge cache and logs
	@rm -rf var/cache/* var/logs/*

up: ## Start the local FrankenPHP stack
	$(DOCKER_COMPOSE) up --detach --wait

build: ## Build the local FrankenPHP images
	$(DOCKER_COMPOSE) build --pull --no-cache

down: ## Stop the docker hub
	$(DOCKER_COMPOSE) down --remove-orphans

sh: ## Log into the FrankenPHP container
	@$(EXEC_PHP) sh

logs: ## Show all logs
	@$(DOCKER_COMPOSE) logs --follow

new-logs: ## Show live logs
	@$(DOCKER_COMPOSE) logs --tail=0 --follow

start: up ## Start docker

stop: ## Stop docker and the Symfony binary server
	$(DOCKER_COMPOSE) stop

commands: ## List all Symfony commands
	@$(SYMFONY) list

load-fixtures: ## Build the DB, control the schema validity, load fixtures and check the migration status
	@$(SYMFONY) doctrine:cache:clear-metadata
	@$(SYMFONY) doctrine:database:create --if-not-exists
	@$(SYMFONY) doctrine:schema:drop --force
	@$(SYMFONY) doctrine:schema:create
	@$(SYMFONY) doctrine:schema:validate
	@$(SYMFONY) d:f:l

coverage-html: ## Create the code coverage report with PHPUnit
	$(DOCKER_COMPOSE) exec -e XDEBUG_MODE=coverage php php -d memory_limit=-1 vendor/bin/phpunit --coverage-html=coverage/html

coverage-xml: ## Create the code coverage report with PHPUnit
	$(DOCKER_COMPOSE) exec -e XDEBUG_MODE=coverage php php -d memory_limit=-1 vendor/bin/phpunit --coverage-clover coverage/coverage.xml

generate-openapi-spec:
	$(EXEC_PHP) php bin/console api:openapi:export --yaml --output=.github/openapi-spec/spec.yaml

validate-openapi-spec: generate-openapi-spec build-spectral-docker ## Generate and lint the OpenAPI spec with Spectral
	./scripts/validate-openapi-spec.sh

validate-configuration: ## Validate directory structure and locked configuration files
	./scripts/validate-configuration.sh

openapi-diff: generate-openapi-spec ## Compare the generated OpenAPI spec against a base reference
	./scripts/openapi-diff.sh $(or $(base_ref),origin/main)

schemathesis-validate: generate-openapi-spec ## Validate the running API against the OpenAPI spec with Schemathesis
	@if echo "$(SCHEMATHESIS_URL)" | grep -Eq '^http://(localhost|127\\.0\\.0\\.1)(:[0-9]+)?(/.*)?$$'; then \
		$(MAKE) setup-test-db; \
	fi
	$(DOCKER) run --rm --network=host -v $(CURDIR)/.github/openapi-spec:/data $(SCHEMATHESIS_IMAGE) run --checks all /data/spec.yaml --url $(SCHEMATHESIS_URL) --phases=examples,coverage

generate-graphql-spec:
	$(EXEC_PHP) php bin/console api:graphql:export --output=.github/graphql-spec/spec

ci: ci-preflight ## Run the main local CI verification stack
	@$(MAKE) ci-static-analysis
	@$(MAKE) ci-deptrac
	@$(MAKE) ci-tests-and-openapi
	@$(MAKE) ci-mutation
	@echo "CI checks successfully passed!"

ci-preflight: ## Run mutating quality steps before the rest of the stack
	@$(MAKE) phpcsfixer
	@$(MAKE) phpmd
	@$(MAKE) phpinsights

ci-static-analysis:
	@$(MAKE) composer-validate
	@$(MAKE) check-requirements
	@$(MAKE) check-security
	@$(MAKE) validate-configuration
	@$(MAKE) psalm
	@$(MAKE) psalm-security

ci-deptrac:
	@$(MAKE) deptrac

ci-tests-and-openapi:
	@$(MAKE) setup-test-db
	@$(MAKE) unit-tests
	@$(MAKE) integration-tests
	@$(MAKE) behat
	@$(MAKE) generate-graphql-spec
	@$(MAKE) openapi-diff
	@$(MAKE) validate-openapi-spec

ci-mutation:
	@$(MAKE) infection

ci-sequential: ci ## Alias for the local CI verification stack

aws-load-tests: ## Run load tests on AWS infrastructure
	tests/Load/aws-execute-load-tests.sh

aws-load-tests-cleanup: ## Cleanup AWS infrastructure after testing
	tests/Load/cleanup.sh
