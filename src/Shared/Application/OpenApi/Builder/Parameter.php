<?php

declare(strict_types=1);

namespace App\Shared\Application\OpenApi\Builder;

final readonly class Parameter
{
    public function __construct(
        public string $name,
        public string $type,
        public string|int|array|bool $example,
        public ?int $maxLength = null,
        public ?string $format = null,
        public bool $required = true
    ) {
    }
}
