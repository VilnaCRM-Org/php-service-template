<?php

declare(strict_types=1);

namespace App\CompanySubdomain\SomeModule\Application\Provider;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\CompanySubdomain\SomeModule\Domain\ExampleApiResource;

/**
 * Returns the placeholder API Platform payload used by the template endpoint.
 *
 * @implements ProviderInterface<ExampleApiResource>
 */
final class ExampleApiResourceProvider implements ProviderInterface
{
    private const DESCRIPTION = <<<'TEXT'
Replace this placeholder endpoint with a real bounded-context API resource.
TEXT;

    /**
     * @param array<string, array|object|scalar|null> $uriVariables
     * @param array<string, array|object|scalar|null> $context
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
