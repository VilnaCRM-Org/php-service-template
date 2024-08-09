<?php

declare(strict_types=1);

namespace App\Tests\Unit\Internal\HealthCheck\Application\EventSubscriber;

use App\Internal\HealthCheck\Application\EventSubscriber\CacheHealthCheckSubscriber;
use App\Internal\HealthCheck\Domain\Event\HealthCheckEvent;
use App\Tests\Unit\UnitTestCase;
use Symfony\Contracts\Cache\CacheInterface;

class CacheHealthCheckSubscriberTest extends UnitTestCase
{
    private CacheInterface $cache;
    private CacheHealthCheckSubscriber $subscriber;

    protected function setUp(): void
    {
        parent::setUp();

        $this->cache = $this->createMock(CacheInterface::class);
        $this->subscriber = new CacheHealthCheckSubscriber($this->cache);
    }

    public function testOnHealthCheck(): void
    {
        $this->cache->expects($this->once())
            ->method('get')
            ->with(
                $this->equalTo('health_check'),
                $this->isInstanceOf(\Closure::class)
            )
            ->willReturn('ok');

        $event = new HealthCheckEvent();
        $this->subscriber->onHealthCheck($event);
    }

    public function testGetSubscribedEvents(): void
    {
        $this->assertSame(
            [HealthCheckEvent::class => 'onHealthCheck'],
            CacheHealthCheckSubscriber::getSubscribedEvents()
        );
    }
}
