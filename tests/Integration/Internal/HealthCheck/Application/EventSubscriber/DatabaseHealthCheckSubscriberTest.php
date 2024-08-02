<?php

declare(strict_types=1);

namespace App\Tests\Integration\Internal\HealthCheck\Application\EventSubscriber;

use App\Internal\HealthCheck\Application\EventSubscriber\DatabaseHealthCheckSubscriber;
use App\Internal\HealthCheck\Domain\Event\HealthCheckEvent;
use App\Tests\Integration\IntegrationTestCase;
use Doctrine\DBAL\Connection;

final class DatabaseHealthCheckSubscriberTest extends IntegrationTestCase
{
    private Connection $connection;
    private DatabaseHealthCheckSubscriber $subscriber;

    protected function setUp(): void
    {
        parent::setUp();

        $this->connection = $this->container->get('doctrine.dbal.default_connection');
        $this->subscriber = new DatabaseHealthCheckSubscriber($this->connection);
    }

    public function testOnHealthCheck(): void
    {
        $event = new HealthCheckEvent();
        $this->subscriber->onHealthCheck($event);

        $result = $this->connection->executeQuery('SELECT 1');
        $fetched = $result->fetchOne();

        $this->assertEquals(1, $fetched);
    }

    public function testGetSubscribedEvents(): void
    {
        $this->assertSame(
            [HealthCheckEvent::class => 'onHealthCheck'],
            DatabaseHealthCheckSubscriber::getSubscribedEvents()
        );
    }
}
