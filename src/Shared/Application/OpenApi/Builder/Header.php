<?php

declare(strict_types=1);

namespace App\Shared\Application\OpenApi\Builder;

final class Header
{
    public function __construct(
        private readonly string $name,
        private readonly string $description,
        private readonly string $type,
        private readonly string $format,
        private readonly string $example
    ) {
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getFormat(): string
    {
        return $this->format;
    }

    public function getExample(): string
    {
        return $this->example;
    }
}
