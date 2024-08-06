<?php

declare(strict_types=1);

namespace App\Internal\HealthCheck\Application\EventSubscriber;

use App\Internal\HealthCheck\Domain\Event\HealthCheckEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Contracts\Cache\CacheInterface;

final class CacheHealthCheckSubscriber implements EventSubscriberInterface
{
    private CacheInterface $cache;

    public function __construct(CacheInterface $cache)
    {
        $this->cache = $cache;
    }

    public function onHealthCheck(HealthCheckEvent $event): void
    {
        $this->cache->get('health_check', static function () {
            return self::cacheMissHandler();
        });
    }

    /**
     * Returns an array of event names this subscriber wants to listen to.
     *
     * @return array<object, string> The event names to listen to
     */
    public static function getSubscribedEvents(): array
    {
        return [HealthCheckEvent::class => 'onHealthCheck'];
    }

    private static function cacheMissHandler(): string
    {
        return 'ok';
    }
}
