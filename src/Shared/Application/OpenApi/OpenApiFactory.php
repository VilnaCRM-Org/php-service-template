<?php

declare(strict_types=1);

namespace App\Shared\Application\OpenApi;

use ApiPlatform\OpenApi\Factory\OpenApiFactoryInterface;
use ApiPlatform\OpenApi\Model\Tag;
use ApiPlatform\OpenApi\OpenApi;

final class OpenApiFactory implements OpenApiFactoryInterface
{
    private const TAG_DESCRIPTIONS = [
        'ExampleApiResource' => 'Template example resource endpoints.',
        'HealthCheck' => 'Runtime health-check endpoints.',
    ];

    public function __construct(
        private OpenApiFactoryInterface $decorated
    ) {
    }

    /**
     * @param array<string, mixed> $context
     */
    public function __invoke(array $context = []): OpenApi
    {
        $openApi = $this->decorated->__invoke($context);

        return $openApi->withTags($this->describeTags($openApi->getTags()));
    }

    /**
     * @param array<int, Tag> $tags
     *
     * @return array<int, Tag>
     */
    private function describeTags(array $tags): array
    {
        $describedTags = [];

        foreach ($tags as $tag) {
            $description = self::TAG_DESCRIPTIONS[$tag->getName()]
                ?? $tag->getDescription();

            $describedTags[] = $description === null
                ? $tag
                : $tag->withDescription($description);
        }

        return $describedTags;
    }
}
