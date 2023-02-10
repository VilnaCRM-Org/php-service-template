.RECIPEPREFIX +=
.PHONY: $(filter-out vendor node_modules,$(MAKECMDGOALS))
.DEFAULT_GOAL := help

help:
	@printf "\033[33mUsage:\033[0m\n  make [target] [arg=\"val\"...]\n\n\033[33mTargets:\033[0m\n"
	@grep -E '^[-a-zA-Z0-9_\.\/]+:.*?## .*$$' $(MAKEFILE_LIST) | sort | awk 'BEGIN {FS = ":.*?## "}; {printf "  \033[32m%-15s\033[0m %s\n", $$1, $$2}'

phpcsfixer: ## A tool to automatically fix PHP Coding Standards issues
	PHP_CS_FIXER_IGNORE_ENV=1 ./vendor/bin/php-cs-fixer fix $(git ls-files -om --exclude-standard) --config .php-cs-fixer.dist.php

composer-validate: ## The validate command validates a given composer.json and composer.lock
	composer validate

check-requirements: ## Checks requirements for running Symfony and gives useful recommendations to optimize PHP for Symfony.
	symfony check:requirements

check-security: ## Checks security issues in project dependencies. Without arguments, it looks for a "composer.lock" file in the current directory. Pass it explicitly to check a specific "composer.lock" file.
	symfony security:check

psalm: ## A static analysis tool for finding errors in PHP applications
	./vendor/bin/psalm

psalm-security: ## Psalm security analysis
	./vendor/bin/psalm --taint-analysis

phpinsights: ## Instant PHP quality checks and static analysis tool
	./vendor/bin/phpinsights --no-interaction

phpunit: ## The PHP unit testing framework
	./vendor/bin/phpunit

behat: ## A php framework for autotesting business expectations
	./vendor/bin/behat

doctrine-migrations-migrate: ## Executes a migration to a specified version or the latest available version
	bin/console d:m:m

doctrine-migrations-generate: ## Generates a blank migration class
	bin/console d:m:g

cache-clear: ## Clears and warms up the application cache for a given environment and debug mode
	bin/console c:c

first-release: ## Generate changelog from a project's commit messages for the first release
	./vendor/bin/conventional-changelog --first-release --commit --no-change-without-commits

changelog-generate: ## Generate changelog from a project's commit messages
	./vendor/bin/conventional-changelog

release: ## Generate changelogs and release notes from a project's commit messages for the first release
	./vendor/bin/conventional-changelog --commit --no-change-without-commits

release-patch: ## Generate changelogs and commit new patch tag from a project's commit messages
	./vendor/bin/conventional-changelog --patch --commit --no-change-without-commits

release-minor: ## Generate changelogs and commit new minor tag from a project's commit messages
	./vendor/bin/conventional-changelog --minor --commit --no-change-without-commits

release-major: ## Generate changelogs and commit new major tag from a project's commit messages
	./vendor/bin/conventional-changelog --major --commit --no-change-without-commits
