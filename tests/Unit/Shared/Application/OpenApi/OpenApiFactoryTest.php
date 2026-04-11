<?php

declare(strict_types=1);

namespace App\Tests\Unit\Shared\Application\OpenApi;

use ApiPlatform\OpenApi\Factory\OpenApiFactoryInterface;
use ApiPlatform\OpenApi\Model\Info;
use ApiPlatform\OpenApi\Model\Paths;
use ApiPlatform\OpenApi\Model\Tag;
use ApiPlatform\OpenApi\OpenApi;
use App\Shared\Application\OpenApi\OpenApiFactory;
use App\Tests\Unit\UnitTestCase;

final class OpenApiFactoryTest extends UnitTestCase
{
    public function testItAddsDescriptionsToKnownTags(): void
    {
        $tags = $this->createFactory()
            ->__invoke(['spec_version' => '3.1'])
            ->getTags();

        self::assertSame(
            [
                'Template example resource endpoints.',
                'Runtime health-check endpoints.',
                'Custom description',
                null,
            ],
            array_map(
                static fn (Tag $tag): ?string => $tag->getDescription(),
                $tags
            )
        );
    }

    private function createFactory(): OpenApiFactory
    {
        $decorated = new class() implements OpenApiFactoryInterface {
            /**
             * @param array<string, array|bool|float|int|object|string|null> $context
             */
            public function __invoke(array $context = []): OpenApi
            {
                return new OpenApi(
                    new Info('Template API', '1.0.0'),
                    [],
                    new Paths(),
                    tags: [
                        new Tag('ExampleApiResource'),
                        new Tag('HealthCheck'),
                        new Tag('CustomTag', 'Custom description'),
                        new Tag('UndocumentedTag'),
                    ]
                );
            }
        };

        return new OpenApiFactory($decorated);
    }
}
