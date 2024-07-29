<?php

namespace App\Internal\HealthCheck\Application\EventSubscriber;

use App\Internal\HealthCheck\Domain\Event\HealthCheckEvent;
use App\Shared\Domain\Bus\Event\DomainEventSubscriberInterface;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception;

final class DatabaseHealthCheckSubscriber implements DomainEventSubscriberInterface
{
    private Connection $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function onHealthCheck(HealthCheckEvent $event): void
    {
        try {
            $this->connection->executeQuery('SELECT 1');
        } catch (Exception $exception) {
        }
    }

    public function subscribedTo(): array
    {
        return [HealthCheckEvent::class];
    }
}
