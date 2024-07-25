<?php

namespace App\Eternal\HealthCheck\Application\Command;

use App\Eternal\HealthCheck\Application\HealthCheckCommandFactoryInterface;

final class HealthCheckCommandFactory implements HealthCheckCommandFactoryInterface
{
    public function create(string $checkType = 'database'): HealthCheckCommand
    {
        return new HealthCheckCommand($checkType);
    }
}
