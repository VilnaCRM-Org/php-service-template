<?php

declare(strict_types=1);

namespace App\Tests\Unit\CompanySubdomain\SomeModule\Application\Provider;

use ApiPlatform\Metadata\Get;
use App\CompanySubdomain\SomeModule\Application\Provider as SomeModuleProvider;
use App\CompanySubdomain\SomeModule\Domain as SomeModuleDomain;
use App\Tests\Unit\UnitTestCase;

/**
 * Covers the template resource provider wiring used by the sample endpoint.
 */
final class ExampleApiResourceProviderTest extends UnitTestCase
{
    /**
     * Ensures the provider returns the documented placeholder payload.
     */
    public function testProvideReturnsTemplatePlaceholderPayload(): void
    {
        $provider = new SomeModuleProvider\ExampleApiResourceProvider();

        $resource = $provider->provide(new Get());
        $expectedDescription = <<<'TEXT'
Replace this placeholder endpoint with a real bounded-context API resource.
TEXT;

        $this->assertInstanceOf(
            SomeModuleDomain\ExampleApiResource::class,
            $resource,
        );
        $this->assertSame('php-service-template', $resource->name);
        $this->assertSame($expectedDescription, $resource->description);
    }
}
