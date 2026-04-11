<?php

declare(strict_types=1);

namespace App\Tests\Unit\CompanySubdomain\SomeModule\Application\Provider;

use ApiPlatform\Metadata\Get;
use App\CompanySubdomain\SomeModule\Application\Provider\ExampleApiResourceProvider;
use App\CompanySubdomain\SomeModule\Domain\ExampleApiResource;
use App\Tests\Unit\UnitTestCase;

final class ExampleApiResourceProviderTest extends UnitTestCase
{
    public function testProvideReturnsTemplatePlaceholderPayload(): void
    {
        $provider = new ExampleApiResourceProvider();

        $resource = $provider->provide(new Get());

        $this->assertInstanceOf(ExampleApiResource::class, $resource);
        $this->assertSame('php-service-template', $resource->name);
        $this->assertSame(
            'Replace this placeholder endpoint with a real bounded-context API resource.',
            $resource->description
        );
    }
}
