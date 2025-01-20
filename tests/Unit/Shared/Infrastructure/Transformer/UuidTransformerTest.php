<?php

declare(strict_types=1);

namespace App\Tests\Unit\Shared\Infrastructure\Transformer;

use App\Shared\Domain\Factory\UuidFactoryInterface;
use App\Shared\Domain\ValueObject\Uuid;
use App\Shared\Infrastructure\Transformer\UuidTransformer;
use App\Tests\Unit\UnitTestCase;
use Symfony\Component\Uid\AbstractUid;

final class UuidTransformerTest extends UnitTestCase
{
    private UuidFactoryInterface $uuidFactory;
    private UuidTransformer $uuidTransformer;

    protected function setUp(): void
    {
        parent::setUp();
        $this->uuidFactory = $this->createMock(UuidFactoryInterface::class);
        $this->uuidTransformer = new UuidTransformer($this->uuidFactory);
    }

    public function testTransformFromSymfonyUuid(): void
    {
        $uuidString = $this->faker->uuid();
        $symfonyUuid = $this->createMock(AbstractUid::class);
        $symfonyUuid->method('__toString')->willReturn($uuidString);

        $expectedUuid = $this->createMock(Uuid::class);

        $this->uuidFactory->expects($this->once())
            ->method('create')
            ->with($uuidString)
            ->willReturn($expectedUuid);

        $result = $this->uuidTransformer
            ->transformFromSymfonyUuid($symfonyUuid);

        $this->assertSame($expectedUuid, $result);
    }

    public function testTransformFromString(): void
    {
        $uuidString = $this->faker->uuid();
        $expectedUuid = $this->createMock(Uuid::class);

        $this->uuidFactory->expects($this->once())
            ->method('create')
            ->with($uuidString)
            ->willReturn($expectedUuid);

        $result = $this->uuidTransformer->transformFromString($uuidString);

        $this->assertSame($expectedUuid, $result);
    }
}
