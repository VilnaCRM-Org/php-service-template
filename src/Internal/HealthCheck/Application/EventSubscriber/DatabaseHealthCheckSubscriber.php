<?php

namespace App\Internal\HealthCheck\Application\EventSubscriber;

use App\Internal\HealthCheck\Domain\Event\HealthCheckEvent;
use Doctrine\DBAL\Connection;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

final class DatabaseHealthCheckSubscriber implements EventSubscriberInterface
{
    private Connection $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function onHealthCheck(HealthCheckEvent $event): void
    {
        $this->connection->executeQuery('SELECT 1');
        $this->connection->getDatabase();
        $this->connection->beginTransaction();
        $this->connection->isConnected();
    }

    public static function getSubscribedEvents(): array
    {
        return [HealthCheckEvent::class => 'onHealthCheck'];
    }
}
