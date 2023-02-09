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
