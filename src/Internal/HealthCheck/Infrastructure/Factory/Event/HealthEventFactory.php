<?php

declare(strict_types=1);

namespace App\Internal\HealthCheck\Infrastructure\Factory\Event;

use App\Internal\HealthCheck\Domain\Event\HealthCheckEvent;
use App\Internal\HealthCheck\Domain\Factory\Event\EventFactoryInterface;

final class HealthEventFactory implements EventFactoryInterface
{
    public function createHealthCheckEvent(): HealthCheckEvent
    {
        return new HealthCheckEvent();
    }
}
