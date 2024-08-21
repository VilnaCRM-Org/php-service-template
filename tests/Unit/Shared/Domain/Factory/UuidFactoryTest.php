<?php

declare(strict_types=1);

namespace App\Tests\Unit\Shared\Domain\Factory;

use App\Shared\Domain\ValueObject\Uuid;
use App\Shared\Infrastructure\Factory\UuidFactory;
use PHPUnit\Framework\TestCase;

final class UuidFactoryTest extends TestCase
{
    public function testCreate(): void
    {
        $factory = new UuidFactory();
        $uuidString = 'f47ac10b-58cc-4372-a567-0e02b2c3d479';

        $result = $factory->create($uuidString);

        $this->assertInstanceOf(Uuid::class, $result);
        $this->assertEquals($uuidString, (string) $result);
    }
}
