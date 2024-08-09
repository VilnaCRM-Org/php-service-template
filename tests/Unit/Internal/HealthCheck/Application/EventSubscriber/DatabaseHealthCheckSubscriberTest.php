<?php

declare(strict_types=1);

namespace App\Tests\Unit\Internal\HealthCheck\Application\EventSubscriber;

use App\Internal\HealthCheck\Application\EventSubscriber\DatabaseHealthCheckSubscriber;
use App\Internal\HealthCheck\Domain\Event\HealthCheckEvent;
use App\Tests\Unit\UnitTestCase;
use Doctrine\DBAL\Connection;

final class DatabaseHealthCheckSubscriberTest extends UnitTestCase
{
    private Connection $connection;
    private DatabaseHealthCheckSubscriber $subscriber;

    protected function setUp(): void
    {
        parent::setUp();

        $this->connection = $this->createMock(Connection::class);
        $this->subscriber = new DatabaseHealthCheckSubscriber($this->connection);
    }

    public function testOnHealthCheck(): void
    {
        $this->connection->expects($this->once())
            ->method('executeQuery')
            ->with('SELECT 1');

        $event = new HealthCheckEvent();
        $this->subscriber->onHealthCheck($event);
    }

    public function testGetSubscribedEvents(): void
    {
        $this->assertSame(
            [HealthCheckEvent::class => 'onHealthCheck'],
            DatabaseHealthCheckSubscriber::getSubscribedEvents()
        );
    }
}
