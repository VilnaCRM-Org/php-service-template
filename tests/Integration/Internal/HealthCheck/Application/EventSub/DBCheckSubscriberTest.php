<?php

declare(strict_types=1);

namespace App\Tests\Integration\Internal\HealthCheck\Application\EventSub;

use App\Internal\HealthCheck\Application\EventSub\DBCheckSubscriber;
use App\Internal\HealthCheck\Domain\Event\HealthCheckEvent;
use App\Tests\Integration\IntegrationTestCase;
use Doctrine\DBAL\Connection;

final class DBCheckSubscriberTest extends IntegrationTestCase
{
    private Connection $connection;
    private DBCheckSubscriber $subscriber;

    protected function setUp(): void
    {
        parent::setUp();

        $this->connection = $this->container->get(
            'doctrine.dbal.default_connection'
        );
        $this->subscriber = new DBCheckSubscriber($this->connection);
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
            DBCheckSubscriber::getSubscribedEvents()
        );
    }
}
