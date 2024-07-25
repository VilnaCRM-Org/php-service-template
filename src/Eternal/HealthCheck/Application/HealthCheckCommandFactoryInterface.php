<?php

declare(strict_types=1);

namespace App\Eternal\HealthCheck\Application;

use App\Eternal\HealthCheck\Application\Command\HealthCheckCommand;

interface HealthCheckCommandFactoryInterface
{
    public function create(string $checkType = 'database'): HealthCheckCommand;
}
