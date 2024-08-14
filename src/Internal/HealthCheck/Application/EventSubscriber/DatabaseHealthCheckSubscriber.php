<?php

declare(strict_types=1);

namespace App\Internal\HealthCheck\Application\EventSubscriber;

use App\Internal\HealthCheck\Domain\Event\HealthCheckEvent;
use Doctrine\DBAL\Connection;

final class DatabaseHealthCheckSubscriber extends BaseHealthCheckSubscriber
{
    private Connection $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function onHealthCheck(HealthCheckEvent $event): void
    {
        $this->connection->executeQuery('SELECT 1');
    }
}
