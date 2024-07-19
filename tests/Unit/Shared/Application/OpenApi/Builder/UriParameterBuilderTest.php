<?php

declare(strict_types=1);

namespace App\Tests\Unit\Shared\Application\OpenApi\Builder;

use ApiPlatform\OpenApi\Model\Parameter;
use App\Shared\Application\OpenApi\Builder\UriParameterBuilder;
use App\Tests\Unit\UnitTestCase;

final class UriParameterBuilderTest extends UnitTestCase
{
    private UriParameterBuilder $builder;

    protected function setUp(): void
    {
        parent::setUp();

        $this->builder = new UriParameterBuilder();
    }

    public function testBuildWithMinimalData(): void
    {
        $name = $this->faker->unique()->word();
        $description = $this->faker->sentence();
        $required = $this->faker->boolean();
        $example = $this->faker->word();
        $type = $this->faker->word();

        $parameter = $this->builder->build(
            $name,
            $description,
            $required,
            $example,
            $type
        );

        $this->assertInstanceOf(Parameter::class, $parameter);
        $this->assertEquals($name, $parameter->getName());
        $this->assertEquals('path', $parameter->getIn());
        $this->assertEquals($description, $parameter->getDescription());
        $this->assertEquals($required, $parameter->getRequired());
        $this->assertEquals(['type' => $type], $parameter->getSchema());
        $this->assertEquals($example, $parameter->getExample());
    }

    public function testBuildWithOptionalParameter(): void
    {
        $name = $this->faker->unique()->word();
        $description = $this->faker->sentence();
        $required = false;
        $example = $this->faker->word();
        $type = $this->faker->word();

        $parameter = $this->builder->build(
            $name,
            $description,
            $required,
            $example,
            $type
        );

        $this->assertInstanceOf(Parameter::class, $parameter);
        $this->assertEquals($name, $parameter->getName());
        $this->assertEquals('path', $parameter->getIn());
        $this->assertEquals($description, $parameter->getDescription());
        $this->assertFalse($parameter->getRequired());
        $this->assertEquals(['type' => $type], $parameter->getSchema());
        $this->assertEquals($example, $parameter->getExample());
    }
}
