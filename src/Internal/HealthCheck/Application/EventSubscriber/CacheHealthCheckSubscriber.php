<?php

namespace App\Internal\HealthCheck\Application\EventSubscriber;

use App\Internal\HealthCheck\Domain\Event\HealthCheckEvent;
use App\Shared\Domain\Bus\Event\DomainEventSubscriberInterface;
use Symfony\Contracts\Cache\CacheInterface;
use Psr\Cache\CacheException;

final class CacheHealthCheckSubscriber implements DomainEventSubscriberInterface
{
    private CacheInterface $cache;

    public function __construct(CacheInterface $cache)
    {
        $this->cache = $cache;
    }

    /**
     * @throws CacheException
     */
    public function __invoke(HealthCheckEvent $event): void
    {
        $this->cache->get('health_check', function() {
            return 'ok';
        });
    }

    public function subscribedTo(): array
    {
        return [HealthCheckEvent::class];
    }
}
