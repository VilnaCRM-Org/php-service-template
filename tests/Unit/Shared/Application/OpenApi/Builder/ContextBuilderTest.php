<?php

declare(strict_types=1);

namespace App\Tests\Unit\Shared\Application\OpenApi\Builder;

use App\Shared\Application\OpenApi\Builder\ContextBuilder;
use App\Shared\Application\OpenApi\Builder\Parameter;
use App\Tests\Unit\UnitTestCase;

final class ContextBuilderTest extends UnitTestCase
{
    private ContextBuilder $contextBuilder;

    protected function setUp(): void
    {
        parent::setUp();

        $this->contextBuilder = new ContextBuilder();
    }

    public function testBuildWithEmptyParams(): void
    {
        $content = $this->contextBuilder->build([]);

        $this->assertEquals(
            new \ArrayObject([
                'application/json' => [
                    'example' => '',
                ],
            ]),
            $content
        );
    }

    public function testBuildWithSimpleParams(): void
    {
        $params = $this->testBuildWithSimpleParamsGetParams();

        $content = $this->contextBuilder->build($params);

        $expectedSchema = $this->buildWithSimpleParamsGetExpectedSchema();

        $expectedExample = [
            'name' => $params[0]->example,
            'age' => $params[1]->example,
        ];

        $this->assertEquals(
            $this->getExpectedResult($expectedSchema, $expectedExample),
            $content
        );
    }

    public function testBuildWithNestedArrays(): void
    {
        $address = [
            'street' => $this->faker->streetName(),
            'city' => $this->faker->city(),
        ];

        $params = [new Parameter('address', 'object', $address)];

        $content = $this->contextBuilder->build($params);

        $expectedSchema = $this->buildWithNestedArraysGetExpectedSchema();

        $expectedExample = ['address' => $address];

        $this->assertEquals(
            $this->getExpectedResult($expectedSchema, $expectedExample),
            $content
        );
    }

    /**
     * @return array<string,string|array<string>>
     */
    private function buildWithSimpleParamsGetExpectedSchema(): array
    {
        return [
            'type' => 'object',
            'properties' => [
                'name' => [
                    'type' => 'string',
                    'maxLength' => null,
                    'format' => null,
                ],
                'age' => [
                    'type' => 'integer',
                    'maxLength' => null,
                    'format' => null,
                ],
            ],
            'required' => ['name', 'age'],
        ];
    }

    /**
     * @return array<string,string|array<string>>
     */
    private function buildWithNestedArraysGetExpectedSchema(): array
    {
        return [
            'type' => 'object',
            'properties' => [
                'address' => [
                    'type' => 'object',
                    'maxLength' => null,
                    'format' => null,
                ],
            ],
            'required' => ['address'],
        ];
    }

    /**
     * @param array<string,string|array<string>> $expectedSchema
     * @param array<string,string|array<string>> $expectedExample
     */
    private function getExpectedResult(
        array $expectedSchema,
        array $expectedExample
    ): \ArrayObject {
        return new \ArrayObject([
            'application/json' => [
                'schema' => $expectedSchema,
                'example' => $expectedExample,
            ],
        ]);
    }

    /**
     * @return array<Parameter>
     */
    private function testBuildWithSimpleParamsGetParams(): array
    {
        return [
            new Parameter(
                'name',
                'string',
                $this->faker->name()
            ),
            new Parameter(
                'age',
                'integer',
                $this->faker->numberBetween(1, 10)
            ),
        ];
    }
}
