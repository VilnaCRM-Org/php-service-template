<?php

declare(strict_types=1);

namespace App\Tests\Integration\Internal\HealthCheck\Application\EventSub;

use App\Internal\HealthCheck\Application\EventSub\CacheCheckSubscriber;
use App\Internal\HealthCheck\Domain\Event\HealthCheckEvent;
use App\Tests\Integration\IntegrationTestCase;
use Symfony\Component\Cache\Adapter\ArrayAdapter;
use Symfony\Contracts\Cache\CacheInterface;

final class CacheCheckSubscriberTest extends IntegrationTestCase
{
    private CacheCheckSubscriber $subscriber;
    private CacheInterface $cache;

    protected function setUp(): void
    {
        parent::setUp();
        $this->cache = new ArrayAdapter();
        $this->subscriber = new CacheCheckSubscriber($this->cache);
    }

    public function testOnHealthCheckCachesResult(): void
    {
        $event = new HealthCheckEvent();
        $this->subscriber->onHealthCheck($event);

        $result = $this->cache->get('health_check', static function () {
            return 'not_ok';
        });

        $this->assertEquals(
            'ok',
            $result,
            'The cache should return "ok" for health_check key'
        );
    }

    public function testGetSubscribedEvents(): void
    {
        $expected = [HealthCheckEvent::class => 'onHealthCheck'];
        $this->assertEquals(
            $expected,
            CacheCheckSubscriber::getSubscribedEvents(),
            'Events should correctly bind to onHealthCheck method'
        );
    }
}
