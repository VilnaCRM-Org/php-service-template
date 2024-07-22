<?php

declare(strict_types=1);

namespace App\Tests\Unit\Shared\Application\Transformer;

use App\Shared\Application\Transformer\UuidTransformer;
use App\Shared\Domain\ValueObject\UuidImpl;
use App\Tests\Unit\UnitTestCase;
use Symfony\Component\Uid\AbstractUid;

final class UuidTransformerTest extends UnitTestCase
{
    public function testTransformFromSymfonyUuid(): void
    {
        $uuid = $this->faker->uuid();
        $symfonyUuid = $this->createMock(AbstractUid::class);
        $symfonyUuid->method('__toString')
            ->willReturn($uuid);

        $uuidTransformer = new UuidTransformer();

        $result = $uuidTransformer->transformFromSymfonyUuid($symfonyUuid);

        $expectedUuid = new UuidImpl($uuid);
        $this->assertEquals($expectedUuid, $result);
    }

    public function testTransformFromString(): void
    {
        $uuid = $this->faker->uuid();

        $uuidTransformer = new UuidTransformer();

        $result = $uuidTransformer->transformFromString($uuid);

        $expectedUuid = new UuidImpl($uuid);
        $this->assertEquals($expectedUuid, $result);
    }
}
