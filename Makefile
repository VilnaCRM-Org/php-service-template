# Load environment variables from .env.test
include .env.test

# Parameters
PROJECT       = php-service-template
GIT_AUTHOR    = Kravalg

# Executables: local only
SYMFONY_BIN   = symfony
DOCKER        = docker
DOCKER_COMPOSE = docker compose

# Determine if we're in CI environment
CI_ENV := $(shell [ -n "$$CI" ] && echo "1" || echo "0")

# Common command prefixes
EXEC_PHP      := $(if $(filter 1,$(CI_ENV)),,$(DOCKER_COMPOSE) exec)
EXEC_PHP_E    := $(if $(filter 1,$(CI_ENV)),,$(DOCKER_COMPOSE) exec -e)
EXEC_PHP_CMD  := $(if $(filter 1,$(CI_ENV)),,$(EXEC_PHP) php)
EXEC_PHP_TEST_ENV := $(EXEC_PHP_E) APP_ENV=test php

# Alias
COMPOSER      := $(if $(filter 1,$(CI_ENV)),composer,$(EXEC_PHP_CMD) composer)
SYMFONY       := $(if $(filter 1,$(CI_ENV)),php bin/console,$(EXEC_PHP_CMD) bin/console)
SYMFONY_BIN   := $(if $(filter 1,$(CI_ENV)),symfony,$(EXEC_PHP_CMD) symfony)
SYMFONY_TEST_ENV := $(EXEC_PHP_TEST_ENV) bin/console

# Executables: vendors
PHPUNIT       = ./vendor/bin/phpunit
PSALM         = ./vendor/bin/psalm
PHP_CS_FIXER  = ./vendor/bin/php-cs-fixer
DEPTRAC       = ./vendor/bin/deptrac
INFECTION     = ./vendor/bin/infection
PHPINSIGHTS   = ./vendor/bin/phpinsights

# Command execution wrapper
define exec_cmd
$(if $(filter 1,$(CI_ENV)),$(1),$(EXEC_PHP_CMD) $(1))
endef

# Misc
.DEFAULT_GOAL = help
.RECIPEPREFIX +=
.PHONY: $(filter-out vendor node_modules,$(MAKECMDGOALS))

help:
	@printf "\033[33mUsage:\033[0m\n  make [target] [arg=\"val\"...]\n\n\033[33mTargets:\033[0m\n"
	@grep -E '^[-a-zA-Z0-9_\.\/]+:.*?## .*$$' $(MAKEFILE_LIST) | sort | awk 'BEGIN {FS = ":.*?## "}; {printf "  \033[32m%-15s\033[0m %s\n", $$1, $$2}'

PHP_CS_FIXER_CMD = PHP_CS_FIXER_IGNORE_ENV=1 $(PHP_CS_FIXER) fix $(shell git ls-files -om --exclude-standard) --allow-risky=yes --config .php-cs-fixer.dist.php

phpcsfixer: ## A tool to automatically fix PHP Coding Standards issues
	$(call exec_cmd,$(PHP_CS_FIXER_CMD))

composer-validate: ## The validate command validates a given composer.json and composer.lock
	$(COMPOSER) validate

check-requirements: ## Checks requirements for running Symfony and gives useful recommendations to optimize PHP for Symfony.
	$(SYMFONY_BIN) check:requirements

check-security: ## Checks security issues in project dependencies.
	$(if $(filter 1,$(CI_ENV)),symfony check:security,$(SYMFONY_BIN) security:check)

psalm: ## A static analysis tool for finding errors in PHP applications
	$(call exec_cmd,$(PSALM))

psalm-security: ## Psalm security analysis
	$(call exec_cmd,$(PSALM) --taint-analysis)

phpinsights: ## Instant PHP quality checks and static analysis tool
	$(call exec_cmd,$(PHPINSIGHTS) --no-interaction)

ci-phpinsights:
	$(PHPINSIGHTS) -n --ansi --format=github-action
	$(PHPINSIGHTS) analyse tests -n --ansi --format=github-action

unit-tests: ## Run unit tests
	$(call exec_cmd,$(PHPUNIT) --testsuite=Unit)

deptrac: ## Check directory structure
	$(call exec_cmd,$(DEPTRAC) analyse --config-file=deptrac.yaml --report-uncovered --fail-on-uncovered)

deptrac-debug: ## Find files unassigned for Deptrac
	$(call exec_cmd,$(DEPTRAC) debug:unassigned --config-file=deptrac.yaml)

behat: ## A php framework for autotesting business expectations
	$(if $(filter 1,$(CI_ENV)),APP_ENV=test $(call exec_cmd,./vendor/bin/behat),$(EXEC_PHP_E) APP_ENV=test php ./vendor/bin/behat)

integration-tests: ## Run integration tests
	$(call exec_cmd,$(PHPUNIT) --testsuite=Integration)

ci-tests:
	$(EXEC_PHP_E) XDEBUG_MODE=coverage APP_ENV=test php sh -c 'php -d memory_limit=-1 $(PHPUNIT) --coverage-clover /coverage/coverage.xml'

e2e-tests: ## Run end-to-end tests
	$(EXEC_PHP_TEST_ENV) ./vendor/bin/behat

setup-test-db: ## Create database for testing purposes
	$(SYMFONY_TEST_ENV) c:c
	$(SYMFONY_TEST_ENV) doctrine:database:drop --force --if-exists
	$(SYMFONY_TEST_ENV) doctrine:database:create
	$(SYMFONY_TEST_ENV) doctrine:migrations:migrate --no-interaction

all-tests: unit-tests integration-tests e2e-tests ## Run unit, integration and e2e tests

smoke-load-tests: build-k6-docker ## Run load tests with minimal load
	tests/Load/run-smoke-load-tests.sh

average-load-tests: build-k6-docker ## Run load tests with average load
	tests/Load/run-average-load-tests.sh

stress-load-tests: build-k6-docker ## Run load tests with high load
	tests/Load/run-stress-load-tests.sh

spike-load-tests: build-k6-docker ## Run load tests with a spike of extreme load
	tests/Load/run-spike-load-tests.sh

load-tests: build-k6-docker ## Run load tests
	tests/Load/run-load-tests.sh

build-k6-docker:
	$(DOCKER) build -t k6 -f ./tests/Load/Dockerfile .

infection: ## Run mutations test.
	$(call exec_cmd,php -d memory_limit=-1 $(INFECTION) --test-framework-options="--testsuite=Unit" --show-mutations -j8)

execute-load-tests-script: build-k6-docker ## Execute single load test scenario.
	tests/Load/execute-load-test.sh $(scenario) $(or $(runSmoke),true) $(or $(runAverage),true) $(or $(runStress),true) $(or $(runSpike),true)

doctrine-migrations-migrate: ## Executes a migration to a specified version or the latest available version
	$(SYMFONY) d:m:m

doctrine-migrations-generate: ## Generates a blank migration class
	$(SYMFONY) d:m:g

cache-clear: ## Clears and warms up the application cache for a given environment and debug mode
	$(SYMFONY) c:c

first-release: ## Generate changelog from a project's commit messages for the first release
	$(EXEC_PHP) ./vendor/bin/conventional-changelog --first-release --commit --no-change-without-commits

changelog-generate: ## Generate changelog from a project's commit messages
	$(EXEC_PHP) ./vendor/bin/conventional-changelog

release: ## Generate changelogs and release notes from a project's commit messages for the first release
	$(EXEC_PHP) ./vendor/bin/conventional-changelog --commit --no-change-without-commits

release-patch: ## Generate changelogs and commit new patch tag from a project's commit messages
	$(EXEC_PHP) ./vendor/bin/conventional-changelog --patch --commit --no-change-without-commits

release-minor: ## Generate changelogs and commit new minor tag from a project's commit messages
	$(EXEC_PHP) ./vendor/bin/conventional-changelog --minor --commit --no-change-without-commits

release-major: ## Generate changelogs and commit new major tag from a project's commit messages
	$(EXEC_PHP) ./vendor/bin/conventional-changelog --major --commit --no-change-without-commits

install: composer.lock ## Install vendors according to the current composer.lock file
	@$(COMPOSER) install --no-progress --prefer-dist --optimize-autoloader

update: ## Update vendors according to the current composer.json file
	@$(COMPOSER) update --no-progress --prefer-dist --optimize-autoloader

cache-warmup: ## Warmup the Symfony cache
	@$(SYMFONY) cache:warmup

fix-perms: ## Fix permissions of all var files
	@chmod -R 777 var/*

purge: ## Purge cache and logs
	@rm -rf var/cache/* var/logs/*

up: ## Start the docker hub (PHP, caddy)
	$(DOCKER_COMPOSE) up --detach

build: ## Builds the images (PHP, caddy)
	$(DOCKER_COMPOSE) build --pull --no-cache

down: ## Stop the docker hub
	$(DOCKER_COMPOSE) down --remove-orphans

sh: ## Log to the docker container
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

stats: ## Commits by the hour for the main author of this project
	@$(GIT) log --author="$(GIT_AUTHOR)" --date=iso | perl -nalE 'if (/^Date:\s+[\d-]{10}\s(\d{2})/) { say $$1+0 }' | sort | uniq -c|perl -MList::Util=max -nalE '$$h{$$F[1]} = $$F[0]; }{ $$m = max values %h; foreach (0..23) { $$h{$$_} = 0 if not exists $$h{$$_} } foreach (sort {$$a <=> $$b } keys %h) { say sprintf "%02d - %4d %s", $$_, $$h{$$_}, "*"x ($$h{$$_} / $$m * 50); }'

coverage-html: ## Create the code coverage report with PHPUnit
	$(EXEC_PHP) php -d memory_limit=-1 $(PHPUNIT) --coverage-html=var/coverage

coverage-xml: ## Create the code coverage report with PHPUnit
	$(EXEC_PHP) php -d memory_limit=-1 $(PHPUNIT) --coverage-clover coverage.xml

generate-openapi-spec:
	$(EXEC_PHP) php bin/console api:openapi:export --yaml --output=.github/openapi-spec/spec.yaml

generate-graphql-spec:
	$(EXEC_PHP) php bin/console api:graphql:export --output=.github/graphql-spec/spec
