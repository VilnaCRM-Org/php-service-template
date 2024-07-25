<?php

declare(strict_types=1);

namespace App\Eternal\HealthCheck\Application\Command;

use App\Shared\Domain\Bus\Command\CommandInterface;

final class HealthCheckCommand implements CommandInterface
{
    public function __construct(public string $checkType = 'database')
    {
    }
}
