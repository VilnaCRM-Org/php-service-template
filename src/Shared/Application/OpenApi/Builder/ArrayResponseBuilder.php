<?php

declare(strict_types=1);

namespace App\Shared\Application\OpenApi\Builder;

use ApiPlatform\OpenApi\Model;
use ApiPlatform\OpenApi\Model\Response;

final class ArrayResponseBuilder
{
    public function __construct(private ArrayContextBuilder $contextBuilder)
    {
    }

    /**
     * @param array<Parameter> $params
     * @param array<Header>    $headers
     */
    public function build(
        string $description,
        array $params,
        array $headers
    ): Response {
        $content = $this->contextBuilder->build($params);
        $headersArray = new \ArrayObject();

        if (count($headers) > 0) {
            foreach ($headers as $header) {
                $headersArray[$header->name] = new Model\Header(
                    description: $header->description,
                    schema: [
                        'type' => $header->type,
                        'format' => $header->format,
                        'example' => $header->example,
                    ]
                );
            }
        }

        return new Response(
            description: $description,
            content: $content,
            headers: $headersArray
        );
    }
}
