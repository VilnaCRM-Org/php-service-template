<?php

declare(strict_types=1);

namespace App\Tests\Unit\Shared\Application\OpenApi\Factory\UriParameter;

use ApiPlatform\OpenApi\Model\Parameter;
use App\Shared\Application\OpenApi\Builder\UriParameterBuilder;
use App\Shared\Application\OpenApi\Factory\UriParameter\UuidUriParameterFactory;
use App\Tests\Unit\UnitTestCase;

final class UuidUriParameterFactoryTest extends UnitTestCase
{
    private UuidUriParameterFactory $factory;
    private UriParameterBuilder $builderMock;

    protected function setUp(): void
    {
        parent::setUp();

        $this->builderMock = $this->createMock(UriParameterBuilder::class);
        $this->factory = new UuidUriParameterFactory($this->builderMock);
    }

    public function testGetParameter(): void
    {
        $name = 'id';
        $description = 'User identifier';
        $example = '2b10b7a3-67f0-40ea-a367-44263321592a';
        $required = true;
        $type = 'string';

        $this->setExpectations($name, $description, $example, $required, $type);

        $parameter = $this->factory->getParameter();

        $this->assertInstanceOf(Parameter::class, $parameter);
        $this->assertEquals($name, $parameter->getName());
        $this->assertEquals('path', $parameter->getIn());
        $this->assertEquals($description, $parameter->getDescription());
        $this->assertTrue($parameter->getRequired());
        $this->assertEquals(['type' => $type], $parameter->getSchema());
        $this->assertEquals($example, $parameter->getExample());
    }

    private function setExpectations(
        string $name,
        string $description,
        string $example,
        bool $required,
        string $type
    ): void {
        $this->builderMock->expects($this->once())
            ->method('build')
            ->with(
                $name,
                $description,
                $required,
                $example,
                $type
            )
            ->willReturn(
                new Parameter(
                    name: $name,
                    in: 'path',
                    description: $description,
                    required: true,
                    schema: ['type' => $type],
                    example: $example
                )
            );
    }
}
