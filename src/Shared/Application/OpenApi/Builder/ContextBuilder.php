<?php

declare(strict_types=1);

namespace App\Shared\Application\OpenApi\Builder;

final class ContextBuilder
{
    /**
     * @param array<Parameter> $params
     */
    public function build(
        array $params,
        string $contentType = 'application/json'
    ): \ArrayObject {
        $content = new \ArrayObject([
            $contentType => [
                'example' => '',
            ],
        ]);

        if (count($params) > 0) {
            $content = $this->processParams($params, $contentType);
        }

        return $content;
    }

    /**
     * @param array<Parameter> $params
     */
    private function processParams(
        array $params,
        string $contentType
    ): \ArrayObject {
        $properties = [];
        $example = [];
        $required = [];

        foreach ($params as $param) {
            if ($param->required) {
                $required[] = $param->name;
            }
            $this->addParameterToProperties($properties, $param);
            $example[$param->name] = $param->example;
        }

        return $this->buildContent(
            $contentType,
            $properties,
            $example,
            $required
        );
    }

    /**
     * @param array<string, string> $properties
     */
    private function addParameterToProperties(
        array &$properties,
        Parameter $param
    ): void {
        $properties[$param->name] = [
            'type' => $param->type,
            'maxLength' => $param->maxLength,
            'format' => $param->format,
        ];
    }

    /**
     * @param array<string, string>           $properties
     * @param array<string, string|int|array> $example
     * @param array<string>                   $required
     */
    private function buildContent(
        string $contentType,
        array $properties,
        array $example,
        array $required
    ): \ArrayObject {
        return new \ArrayObject([
            $contentType => [
                'schema' => [
                    'type' => 'object',
                    'properties' => $properties,
                    'required' => $required,
                ],
                'example' => $example,
            ],
        ]);
    }
}
