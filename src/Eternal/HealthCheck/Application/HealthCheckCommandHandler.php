<?php

declare(strict_types=1);

namespace App\Eternal\HealthCheck\Application;

use App\Eternal\HealthCheck\Application\Command\HealthCheckCommand;
use App\Eternal\HealthCheck\Domain\Factory\Event\EventFactoryInterface;
use App\Shared\Domain\Bus\Command\CommandHandlerInterface;
use App\Shared\Domain\Bus\Event\EventBusInterface;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception;
use Symfony\Component\Validator\Constraints\Uuid;

final class HealthCheckCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private Connection $connection,
        private EventBusInterface $eventBus,
        private EventFactoryInterface $eventFactory
    ) {
    }

    public function __invoke(HealthCheckCommand $command): void
    {
        $eventId = (string) Uuid::v4();
        $isHealthy = $this->checkDatabaseHealth();

        if (!$isHealthy) {
            $event = $this->eventFactory->createHealthCheckFailedEvent($eventId, $command->checkType, 'Database check failed');
            $this->eventBus->publish($event);
        } else {
            $event = $this->eventFactory->createHealthCheckSuccessEvent($eventId, $command->checkType);
            $this->eventBus->publish($event);
        }
    }

    private function checkDatabaseHealth(): bool
    {
        try {
            $this->connection->executeQuery('SELECT 1');

            return true;
        } catch (Exception $e) {
            return false;
        }
    }
}
