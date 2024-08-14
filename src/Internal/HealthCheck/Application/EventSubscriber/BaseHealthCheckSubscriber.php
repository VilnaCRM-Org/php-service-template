<?php

declare(strict_types=1);

namespace App\Internal\HealthCheck\Application\EventSubscriber;

use App\Internal\HealthCheck\Domain\Event\HealthCheckEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

abstract class BaseHealthCheckSubscriber implements EventSubscriberInterface
{
    /**
     * @return array<class-string, string>
     */
    public static function getSubscribedEvents(): array
    {
        return [HealthCheckEvent::class => 'onHealthCheck'];
    }

    abstract public function onHealthCheck(HealthCheckEvent $event): void;
}
