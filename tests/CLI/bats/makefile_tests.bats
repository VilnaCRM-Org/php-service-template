#!/usr/bin/env bats

load 'bats-support/load'
load 'bats-assert/load'

@test "make infection should fail due to partly covered class" {
  cat << EOF > src/Shared/Infrastructure/Bus/Event/PartlyCoveredEventBus.php
<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Bus\Event;

use App\Shared\Domain\Bus\Event\DomainEvent;
use App\Shared\Domain\Bus\Event\EventBus;
use Symfony\Component\Messenger\MessageBus;

final class PartlyCoveredEventBus implements EventBus
{
    private MessageBus \$bus;

    public function __construct(MessageBus \$bus)
    {
        \$this->bus = \$bus;
    }

    public function publish(DomainEvent ...\$events): void
    {
        foreach (\$events as \$event) {
            \$this->bus->dispatch(\$event);
        }
    }

    public function getEventCount(array \$events): int
    {
        \$count = 0;
        foreach (\$events as \$event) {
            if (\$event instanceof DomainEvent) {
                \$count++;
            }
        }
        return \$count;
    }
}
EOF
  composer dump-autoload

  run make unit-tests
  run make infection

  rm -f src/Shared/Infrastructure/Bus/Event/PartlyCoveredEventBus.php
  rm -f tests/Unit/Shared/Infrastructure/Bus/Event/PartlyCoveredEventBusTest.php

  assert_output --partial "8 mutants were not covered by tests"
}

@test "make behat should fail when scenarios fail" {
  mv tests/Behat/DemoContext.php tests/
  run make behat
  mv tests/DemoContext.php tests/Behat/
  assert_failure
}

@test "make psalm should fail when there are errors" {
  TEST_DIR="src/Shared/Application/PsalmTest_$(date +%s)"
  mkdir -p "$TEST_DIR"
  cat << EOF > "$TEST_DIR/PsalmErrorExample.php"
<?php
declare(strict_types=1);

namespace App\Shared\Application\PsalmTest;

class PsalmErrorExample
{
    public function exampleMethod(): void
    {
        \$undefinedVariable;  // This will cause a Psalm error
        \$number = "not a number";
        return \$number;  // This will cause another Psalm error (invalid return type)
    }
}
EOF

  run make psalm

  rm -rf "$TEST_DIR"

  assert_failure
  assert_output --partial "UndefinedVariable"
  assert_output --partial "InvalidReturnType"
}

@test "make deptrac should fail when there are dependency violations" {
  mkdir -p src/Shared/Domain/Factory
  cat << EOF > src/Shared/Domain/Factory/UuidTransformer.php
<?php

declare(strict_types=1);

namespace App\Shared\Domain\Factory;

use App\Shared\Domain\ValueObject\Uuid;
use Symfony\Component\Uid\AbstractUid as SymfonyUuid;

final readonly class UuidTransformer
{
    public function __construct(
        private UuidFactoryInterface \$uuidFactory
    ) {
    }

    public function transformFromSymfonyUuid(SymfonyUuid \$symfonyUuid): Uuid
    {
        return \$this->createUuid((string) \$symfonyUuid);
    }

    public function transformFromString(string \$uuid): Uuid
    {
        return \$this->createUuid(\$uuid);
    }

    private function createUuid(string \$uuid): Uuid
    {
        return \$this->uuidFactory->create(\$uuid);
    }
}
EOF

  run make deptrac

  # Clean up the temporary file
  rm -f src/Shared/Domain/Factory/UuidTransformer.php
  rmdir src/Shared/Domain/Factory

  assert_failure
  assert_output --partial "Violation"
  assert_output --partial "App\\Shared\\Domain\\Factory\\UuidTransformer"
  assert_output --partial "must not depend on"
  assert_output --partial "Symfony\\Component\\Uid\\AbstractUid"
}

@test "make e2e-tests should fail when scenarios fail" {
  mv tests/Behat/DemoContext.php tests/
    run make behat
    mv tests/DemoContext.php tests/Behat/
    assert_failure
}

@test "make phpinsights should fail when code quality is low" {
  echo "<?php while(true){echo 'infinite loop';}" > temp_bad_code.php
  run make phpinsights
  rm temp_bad_code.php
  assert_output --partial "The style score is too low"
}

@test "make unit-tests should fail if tests fail" {
  # Temporarily create a failing test
  echo "<?php
  use PHPUnit\Framework\TestCase;
  class FailingTest extends TestCase {
    public function testFailure() {
      \$this->assertTrue(false);
    }
  }" > tests/Unit/FailingTest.php

  run make unit-tests

  # Remove the temporary test
  rm tests/Unit/FailingTest.php

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
  # Temporarily modify composer.json to make it invalid
  mv composer.json composer.json.bak
  echo "{" > composer.json

  run make composer-validate

  # Restore original composer.json
  mv composer.json.bak composer.json

  assert_failure
  assert_output --partial "does not contain valid JSON"
}

@test "make check-security should report vulnerabilities if present" {
  # Temporarily create a composer.lock file with a known vulnerable package
  cat << EOF > composer.lock
{
    "packages": [
        {
            "name": "symfony/http-kernel",
            "version": "v4.4.0"
        }
    ]
}
EOF

  run make check-security

  # Remove the temporary composer.lock file
  rm composer.lock
  assert_failure
  assert_output --partial "symfony/http-kernel (v4.4.0)"
  assert_output --partial "1 package has known vulnerabilities"
  composer install
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
