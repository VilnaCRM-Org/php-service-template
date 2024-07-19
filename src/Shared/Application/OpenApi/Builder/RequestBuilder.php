<?php

declare(strict_types=1);

namespace App\Shared\Application\OpenApi\Builder;

use ApiPlatform\OpenApi\Model\RequestBody;

final class RequestBuilder
{
    public function __construct(private ContextBuilder $contextBuilder)
    {
    }

    /**
     * @param array<Parameter> $params
     */
    public function build(
        array $params,
        bool $required = true,
        string $contentType = 'application/json'
    ): RequestBody {
        $content = $this->contextBuilder->build($params, $contentType);

        return new RequestBody(
            content: $content,
            required: $required
        );
    }
}
