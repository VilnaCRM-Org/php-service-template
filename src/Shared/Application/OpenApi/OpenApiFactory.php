<?php

declare(strict_types=1);

namespace App\Shared\Application\OpenApi;

use ApiPlatform\OpenApi\Factory\OpenApiFactoryInterface;
use ApiPlatform\OpenApi\Model\Operation;
use ApiPlatform\OpenApi\Model\PathItem;
use ApiPlatform\OpenApi\Model\Paths;
use ApiPlatform\OpenApi\Model\Response;
use ApiPlatform\OpenApi\Model\Tag;
use ApiPlatform\OpenApi\OpenApi;

final class OpenApiFactory implements OpenApiFactoryInterface
{
    private const TAG_DESCRIPTIONS = [
        'ExampleApiResource' => 'Template example resource endpoints.',
        'HealthCheck' => 'Runtime health-check endpoints.',
    ];
    private const DEFAULT_PROBLEM_RESPONSE_DESCRIPTION = 'Problem response.';

    public function __construct(
        private OpenApiFactoryInterface $decorated
    ) {
    }

    /**
     * @param array<string, array|bool|float|int|object|string|null> $context
     */
    public function __invoke(array $context = []): OpenApi
    {
        $openApi = $this->decorated->__invoke($context);
        $openApi = $openApi->withPaths($this->describePaths($openApi->getPaths()));

        return $openApi->withTags($this->describeTags($openApi->getTags()));
    }

    /**
     * @param array<int, Tag> $tags
     *
     * @return array<int, Tag>
     */
    private function describeTags(array $tags): array
    {
        return array_map($this->describeTag(...), $tags);
    }

    private function describeTag(Tag $tag): Tag
    {
        $description = self::TAG_DESCRIPTIONS[$tag->getName()]
            ?? $tag->getDescription();

        return $description === null
            ? $tag
            : $tag->withDescription($description);
    }

    private function describePaths(Paths $paths): Paths
    {
        $describedPaths = new Paths();

        foreach ($paths->getPaths() as $path => $pathItem) {
            $describedPaths->addPath($path, $this->describePathItem($pathItem));
        }

        return $describedPaths;
    }

    private function describePathItem(PathItem $pathItem): PathItem
    {
        foreach (PathItem::$methods as $method) {
            $accessor = ucfirst(strtolower($method));
            $getter = "get{$accessor}";
            $wither = "with{$accessor}";
            $operation = $pathItem->$getter();

            if (!$operation instanceof Operation) {
                continue;
            }

            $pathItem = $pathItem->$wither($this->describeOperation($operation));
        }

        return $pathItem;
    }

    private function describeOperation(Operation $operation): Operation
    {
        return $this->hasProblemResponse($operation->getResponses())
            ? $operation
            : $operation->withResponse(
                'default',
                new Response(self::DEFAULT_PROBLEM_RESPONSE_DESCRIPTION)
            );
    }

    /**
     * @param array<string, Response>|null $responses
     */
    private function hasProblemResponse(?array $responses): bool
    {
        if ($responses === null) {
            return false;
        }

        foreach (array_keys($responses) as $status) {
            if ($status === 'default' || preg_match('/^4\d{2}$/', (string) $status) === 1) {
                return true;
            }
        }

        return false;
    }
}
