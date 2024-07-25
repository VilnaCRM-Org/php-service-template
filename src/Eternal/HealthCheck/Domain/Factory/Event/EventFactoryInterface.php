<?php

declare(strict_types=1);

namespace App\Eternal\HealthCheck\Domain\Factory\Event;

use App\Eternal\HealthCheck\Domain\Event\HealthCheckFailedEvent;
use App\Eternal\HealthCheck\Domain\Event\HealthCheckSuccessEvent;

interface EventFactoryInterface
{
    public function createHealthCheckSuccessEvent(string $eventId, string $checkType): HealthCheckSuccessEvent;

    public function createHealthCheckFailedEvent(string $eventId, string $checkType, string $reason): HealthCheckFailedEvent;
}
