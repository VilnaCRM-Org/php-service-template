<?php

declare(strict_types=1);

namespace App\Tests\Unit\Shared\Application\OpenApi\Builder;

use ApiPlatform\OpenApi\Model\Header as ApiPlatformHeader;
use ApiPlatform\OpenApi\Model\Response;
use App\Shared\Application\OpenApi\Builder\ContextBuilder;
use App\Shared\Application\OpenApi\Builder\Header;
use App\Shared\Application\OpenApi\Builder\Parameter;
use App\Shared\Application\OpenApi\Builder\ResponseBuilder;
use App\Tests\Unit\UnitTestCase;

final class ResponseBuilderTest extends UnitTestCase
{
    private ResponseBuilder $builder;
    private ContextBuilder $contextBuilderMock;
    private string $description;
    private string $paramName;
    private string $paramType;
    private string $paramExample;
    private string $headerName;
    private string $headerDescription;
    private string $headerType;
    private string $headerFormat;
    private string $headerExample;

    protected function setUp(): void
    {
        parent::setUp();

        $this->contextBuilderMock =
            $this->createMock(ContextBuilder::class);
        $this->builder = new ResponseBuilder($this->contextBuilderMock);
        $this->description = $this->faker->sentence();
        $this->paramName = $this->faker->word();
        $this->paramType = $this->faker->word();
        $this->paramExample = $this->faker->word();
        $this->headerName = $this->faker->word();
        $this->headerDescription = $this->faker->sentence();
        $this->headerType = $this->faker->word();
        $this->headerFormat = $this->faker->word();
        $this->headerExample = $this->faker->word();
    }

    public function testBuildWithMinimalData(): void
    {
        $this->contextBuilderMock->expects($this->once())
            ->method('build')
            ->with([])
            ->willReturn(new \ArrayObject([]));

        $response = $this->builder->build($this->description, [], []);

        $this->assertInstanceOf(Response::class, $response);
        $this->assertEquals($this->description, $response->getDescription());
        $this->assertEquals(new \ArrayObject([]), $response->getHeaders());
    }

    public function testBuildWithParamsAndHeaders(): void
    {
        $params = $this->getParams();

        $headers = $this->getHeaders();

        $expectedContent = $this->getExpectedContent();

        $expectedHeaders = $this->getExpectedHeaders();

        $this->contextBuilderMock->expects($this->once())
            ->method('build')
            ->with($params)
            ->willReturn($expectedContent);

        $response =
            $this->builder->build($this->description, $params, $headers);
        $this->assertEquals($this->description, $response->getDescription());
        $this->assertEquals($expectedContent, $response->getContent());
        $this->assertEquals($expectedHeaders, $response->getHeaders());
    }

    private function getExpectedContent(): \ArrayObject
    {
        return new \ArrayObject([
            'application/json' => [
                'schema' => [
                    'type' => 'object',
                    'properties' => [
                        $this->paramName => ['type' => $this->paramExample],
                    ],
                ],
                'example' => [
                    $this->paramName => $this->paramExample,
                ],
            ],
        ]);
    }

    /**
     * @return array<Parameter>
     */
    private function getParams(): array
    {
        return [
            new Parameter(
                $this->paramName,
                $this->paramType,
                $this->paramExample
            ),
        ];
    }

    /**
     * @return array<Header>
     */
    private function getHeaders(): array
    {
        return [
            new Header(
                $this->headerName,
                $this->headerDescription,
                $this->headerType,
                $this->headerFormat,
                $this->headerExample
            ),
        ];
    }

    private function getExpectedHeaders(): \ArrayObject
    {
        return new \ArrayObject([
            $this->headerName => new ApiPlatformHeader(
                description: $this->headerDescription,
                schema: [
                    'type' => $this->headerType,
                    'format' => $this->headerFormat,
                    'example' => $this->headerExample,
                ],
            ),
        ]);
    }
}
