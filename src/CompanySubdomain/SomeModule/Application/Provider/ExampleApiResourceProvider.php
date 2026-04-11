<?php

declare(strict_types=1);

namespace App\CompanySubdomain\SomeModule\Application\Provider;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\CompanySubdomain\SomeModule\Domain\ExampleApiResource;

final class ExampleApiResourceProvider implements ProviderInterface
{
    private const DESCRIPTION = 'Replace this placeholder endpoint with a real bounded-context API resource.';

    /**
     * @param array<string, mixed> $uriVariables
     * @param array<string, mixed> $context
     */
    public function provide(
        Operation $operation,
        array $uriVariables = [],
        array $context = []
    ): ExampleApiResource {
        return new ExampleApiResource(
            name: 'php-service-template',
            description: self::DESCRIPTION
        );
    }
}
