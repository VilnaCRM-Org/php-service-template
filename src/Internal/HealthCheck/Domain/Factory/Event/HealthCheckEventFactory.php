<?php

declare(strict_types=1);

namespace App\Internal\HealthCheck\Domain\Factory\Event;

use App\Internal\HealthCheck\Domain\Event\HealthCheckEvent;

final class HealthCheckEventFactory implements EventFactoryInterface
{
    public function createHealthCheckEvent(): HealthCheckEvent
    {
        return new HealthCheckEvent();
    }
}
