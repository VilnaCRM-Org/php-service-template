<?php

declare(strict_types=1);

namespace App\Tests\Unit\Shared\Domain\ValueObject;

use App\Shared\Domain\ValueObject\UuidImpl;
use App\Tests\Unit\UnitTestCase;

final class UuidImplTest extends UnitTestCase
{
    public function testConstructor(): void
    {
        $uuidString = $this->faker->uuid();
        $uuid = new UuidImpl($uuidString);

        $this->assertSame($uuidString, (string) $uuid);
    }

    public function testToString(): void
    {
        $uuidString = $this->faker->uuid();
        $uuid = new UuidImpl($uuidString);

        $this->assertSame($uuidString, $uuid->__toString());
    }

    public function testToBinaryConvertible(): void
    {
        $uuidString = $this->faker->uuid();
        $uuid = new UuidImpl($uuidString);

        $expectedBinary = hex2bin(
            str_replace('-', '', $uuidString)
        );

        $this->assertSame($expectedBinary, $uuid->toBinary());
    }

    public function testToBinaryConvertibleWithNonDefaultLength(): void
    {
        $additionalChars = 'aa';
        $uuidString = $this->faker->uuid().$additionalChars;
        $uuid = new UuidImpl($uuidString);

        $expectedBinary = hex2bin(
            str_replace('-', '', $uuidString)
        );

        $this->assertSame($expectedBinary, $uuid->toBinary());
    }

    public function testToBinaryNotConvertible(): void
    {
        $additionalChar = 'a';
        $uuidString = $this->faker->uuid().$additionalChar;
        $uuid = new UuidImpl($uuidString);

        $this->assertNull($uuid->toBinary());
    }
}
