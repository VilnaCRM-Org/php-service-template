<?php

declare(strict_types=1);

namespace App\CompanySubdomain\SomeModule\Application\Provider;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\CompanySubdomain\SomeModule\Domain\ExampleApiResource;

final class ExampleApiResourceProvider implements ProviderInterface
{
    public function provide(
        Operation $operation,
        array $uriVariables = [],
        array $context = []
    ): ExampleApiResource {
        return new ExampleApiResource(
            name: 'php-service-template',
            description: 'Replace this placeholder endpoint with a real bounded-context API resource.'
        );
    }
}
