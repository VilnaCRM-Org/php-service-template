<?php

declare(strict_types=1);

namespace App\Shared\Application\OpenApi;

use ApiPlatform\OpenApi\Factory\OpenApiFactoryInterface;
use ApiPlatform\OpenApi\Model\Tag;
use ApiPlatform\OpenApi\OpenApi;

final class OpenApiFactory implements OpenApiFactoryInterface
{
    private const TAG_DESCRIPTIONS = [
        'ExampleApiResource' => 'Example API Platform resource endpoints'
            . ' used as the template baseline.',
        'HealthCheck' => 'Service readiness endpoints'
            . ' for runtime health verification.',
    ];

    public function __construct(
        private OpenApiFactoryInterface $decorated
    ) {
    }

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
