<?php

declare(strict_types=1);

namespace App\Tests\Unit\Shared\Application\OpenApi\Builder;

use App\Shared\Application\OpenApi\Builder\Header;
use App\Tests\Unit\UnitTestCase;

final class HeaderTest extends UnitTestCase
{
    public function testCreateWithValidData(): void
    {
        $headerValue = $this->faker->word();
        $description = $this->faker->word();
        $type = $this->faker->word();
        $format = $this->faker->word();
        $example = $this->faker->word();

        $header = new Header(
            $headerValue,
            $description,
            $type,
            $format,
            $example
        );

        $this->assertEquals($headerValue, $header->getName());
        $this->assertEquals($description, $header->getDescription());
        $this->assertEquals($type, $header->getType());
        $this->assertEquals($format, $header->getFormat());
        $this->assertEquals($example, $header->getExample());
    }
}
