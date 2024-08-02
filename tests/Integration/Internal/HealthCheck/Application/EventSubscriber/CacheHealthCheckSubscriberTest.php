<?php

declare(strict_types=1);

namespace App\Tests\Integration\Internal\HealthCheck\Application\EventSubscriber;

use App\Internal\HealthCheck\Application\EventSubscriber\CacheHealthCheckSubscriber;
use App\Internal\HealthCheck\Domain\Event\HealthCheckEvent;
use App\Tests\Integration\IntegrationTestCase;
use Symfony\Component\Cache\Adapter\ArrayAdapter;
use Symfony\Contracts\Cache\CacheInterface;

class CacheHealthCheckSubscriberTest extends IntegrationTestCase
{
    private CacheHealthCheckSubscriber $subscriber;
    private CacheInterface $cache;

    protected function setUp(): void
    {
        parent::setUp();
        $this->cache = new ArrayAdapter();
        $this->subscriber = new CacheHealthCheckSubscriber($this->cache);
    }

    public function testOnHealthCheckCachesResult(): void
    {
        $event = new HealthCheckEvent();
        $this->subscriber->onHealthCheck($event);

        $result = $this->cache->get('health_check', function () {
            return 'not_ok';
        });

        $this->assertEquals('ok', $result, 'The cache should return "ok" for health_check key');
    }

    public function testGetSubscribedEvents(): void
    {
        $expected = [HealthCheckEvent::class => 'onHealthCheck'];
        $this->assertEquals(
            $expected,
            CacheHealthCheckSubscriber::getSubscribedEvents(),
            'Events should correctly bind to onHealthCheck method'
        );
    }
}
