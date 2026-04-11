<?php

declare(strict_types=1);

namespace App\Tests\Unit\Shared\Application\OpenApi;

use ApiPlatform\OpenApi\Factory\OpenApiFactoryInterface;
use ApiPlatform\OpenApi\Model\Info;
use ApiPlatform\OpenApi\Model\Operation;
use ApiPlatform\OpenApi\Model\PathItem;
use ApiPlatform\OpenApi\Model\Paths;
use ApiPlatform\OpenApi\Model\Response;
use ApiPlatform\OpenApi\Model\Tag;
use ApiPlatform\OpenApi\OpenApi;
use App\Shared\Application\OpenApi\OpenApiFactory;
use App\Tests\Unit\UnitTestCase;

final class OpenApiFactoryTest extends UnitTestCase
{
    public function testItAddsDescriptionsToKnownTags(): void
    {
        $openApi = $this->createFactory()->__invoke(['spec_version' => '3.1']);
        $tags = $openApi->getTags();

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

        self::assertSame(
            [200, 'default'],
            array_keys(
                $openApi->getPaths()
                    ->getPath('/example')
                    ?->getGet()
                    ?->getResponses() ?? []
            )
        );

        self::assertSame(
            [500, 'default'],
            array_keys(
                $openApi->getPaths()
                    ->getPath('/health')
                    ?->getGet()
                    ?->getResponses() ?? []
            )
        );

        self::assertSame(
            [404],
            array_keys(
                $openApi->getPaths()
                    ->getPath('/problem')
                    ?->getGet()
                    ?->getResponses() ?? []
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
                $paths = new Paths();
                $paths->addPath(
                    '/example',
                    new PathItem(
                        get: new Operation(
                            responses: [
                                '200' => new Response('Example response.'),
                            ]
                        )
                    )
                );
                $paths->addPath(
                    '/health',
                    new PathItem(
                        get: new Operation(
                            responses: [
                                '500' => new Response('Health check failed.'),
                            ]
                        )
                    )
                );
                $paths->addPath(
                    '/problem',
                    new PathItem(
                        get: new Operation(
                            responses: [
                                '404' => new Response('Not found.'),
                            ]
                        )
                    )
                );

                return new OpenApi(
                    new Info('Template API', '1.0.0'),
                    [],
                    $paths,
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
