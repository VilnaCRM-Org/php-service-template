<?php

declare(strict_types=1);

namespace App\Tests\Unit\Shared\Application\OpenApi\Builder;

use ApiPlatform\OpenApi\Model\Parameter;
use App\Shared\Application\OpenApi\Builder\QueryParameterBuilder;
use App\Tests\Unit\UnitTestCase;

final class QueryParameterBuilderTest extends UnitTestCase
{
    private QueryParameterBuilder $builder;

    protected function setUp(): void
    {
        parent::setUp();

        $this->builder = new QueryParameterBuilder();
    }

    public function testBuildWithValidData(): void
    {
        $name = $this->faker->name();
        $description = $this->faker->title();
        $required = true;
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
        $this->assertEquals('query', $parameter->getIn());
        $this->assertEquals($description, $parameter->getDescription());
        $this->assertTrue($parameter->getRequired());
        $this->assertEquals(['type' => $type], $parameter->getSchema());
        $this->assertEquals($example, $parameter->getExample());
    }

    public function testBuildWithOptionalParameter(): void
    {
        $name = $this->faker->name();
        $description = $this->faker->title();
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

        $this->assertFalse($parameter->getRequired());
    }
}
