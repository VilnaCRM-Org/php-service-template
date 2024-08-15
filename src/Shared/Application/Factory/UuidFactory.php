<?php

declare(strict_types=1);

namespace App\Shared\Application\Factory;

use App\Shared\Domain\ValueObject\Uuid;

final class UuidFactory
{
    public function create(string $uuid): Uuid
    {
        return new Uuid($uuid);
    }
}
