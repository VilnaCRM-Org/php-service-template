<?php

declare(strict_types=1);

namespace App\Shared\Domain\Factory;

use App\Shared\Domain\ValueObject\Uuid;

interface UuidFactoryInterface
{
    public function create(string $uuid): Uuid;
}
