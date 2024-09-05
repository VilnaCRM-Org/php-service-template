<?php

declare(strict_types=1);

namespace App\Internal\HealthCheck\Application\EventSub;

use App\Internal\HealthCheck\Domain\Event\HealthCheckEvent;
use Symfony\Contracts\Cache\CacheInterface;

final class CacheCheckSubscriber extends BaseHealthCheckSubscriber
{
    private CacheInterface $cache;

    public function __construct(CacheInterface $cache)
    {
        $this->cache = $cache;
    }

    public function onHealthCheck(HealthCheckEvent $event): void
    {
        $this->cache->get('health_check', static fn (
        ) => self::cacheMissHandler());
    }

    private static function cacheMissHandler(): string
    {
        return 'ok';
    }
}
