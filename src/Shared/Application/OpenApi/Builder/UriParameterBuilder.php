<?php

declare(strict_types=1);

namespace App\Shared\Application\OpenApi\Builder;

use ApiPlatform\OpenApi\Model\Parameter;

final class UriParameterBuilder
{
    public function build(
        string $name,
        string $description,
        bool $required,
        string $example,
        string $type
    ): Parameter {
        return new Parameter(
            name: $name,
            in: 'path',
            description: $description,
            required: $required,
            schema: ['type' => $type],
            example: $example
        );
    }
}
