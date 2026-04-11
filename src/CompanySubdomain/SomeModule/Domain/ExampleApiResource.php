<?php

declare(strict_types=1);

namespace App\CompanySubdomain\SomeModule\Domain;

final class ExampleApiResource
{
    public function __construct(
        public readonly string $name,
        public readonly string $description
    ) {
    }
}
