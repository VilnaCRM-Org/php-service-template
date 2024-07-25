<?php

namespace App\Eternal\HealthCheck\Domain\Factory\Event;

use App\Eternal\HealthCheck\Domain\Event\HealthCheckFailedEvent;
use App\Eternal\HealthCheck\Domain\Event\HealthCheckSuccessEvent;

final class EventFactory implements EventFactoryInterface
{
    public function createHealthCheckSuccessEvent(string $eventId, string $checkType): HealthCheckSuccessEvent
    {
        return new HealthCheckSuccessEvent($eventId, $checkType);
    }

    public function createHealthCheckFailedEvent(string $eventId, string $checkType, string $reason): HealthCheckFailedEvent
    {
        return new HealthCheckFailedEvent($eventId, $checkType, $reason);
    }
}
