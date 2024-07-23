<?php

declare(strict_types=1);

namespace App\Shared\Domain\ValueObject;

interface UuidInterface
{
    public function __toString(): string;

    public function toBinary(): ?string;
}
