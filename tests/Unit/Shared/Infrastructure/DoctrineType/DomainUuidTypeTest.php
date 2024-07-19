<?php

declare(strict_types=1);

namespace App\Tests\Unit\Shared\Infrastructure\DoctrineType;

use App\Shared\Application\Transformer\UuidTransformer;
use App\Shared\Infrastructure\DoctrineType\DomainUuidType;
use App\Tests\Unit\UnitTestCase;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Symfony\Component\Uid\Factory\UuidFactory;

final class DomainUuidTypeTest extends UnitTestCase
{
    private DomainUuidType $domainUuidType;
    private UuidFactory $symfonyUuidFactory;
    private UuidTransformer $transformer;

    protected function setUp(): void
    {
        parent::setUp();

        $this->domainUuidType = new DomainUuidType();
        $this->symfonyUuidFactory = new UuidFactory();
        $this->transformer = new UuidTransformer();
    }

    public function testGetName(): void
    {
        $this->assertSame(
            'domain_uuid',
            $this->domainUuidType->getName()
        );
    }

    public function testGetSQLDeclaration(): void
    {
        $platform = $this->createMock(AbstractPlatform::class);
        $expectedSqlDeclaration = $this->faker->word();

        $platform->method('getGuidTypeDeclarationSQL')
            ->willReturn($expectedSqlDeclaration);

        $sqlDeclaration =
            $this->domainUuidType->getSQLDeclaration([], $platform);

        $this->assertSame($expectedSqlDeclaration, $sqlDeclaration);
    }

    public function testConvertToDatabaseValue(): void
    {
        $platform = $this->createMock(AbstractPlatform::class);
        $value = $this->transformer->transformFromSymfonyUuid(
            $this->symfonyUuidFactory->create()
        );
        $expectedBinaryValue = $value->toBinary();

        $binaryValue =
            $this->domainUuidType->convertToDatabaseValue($value, $platform);

        $this->assertSame($expectedBinaryValue, $binaryValue);
    }

    public function testConvertToDatabaseValueFromString(): void
    {
        $platform = $this->createMock(AbstractPlatform::class);
        $uuid = $this->transformer->transformFromSymfonyUuid(
            $this->symfonyUuidFactory->create()
        );
        $expectedBinaryValue = $uuid->toBinary();
        $value = (string) $uuid;

        $binaryValue =
            $this->domainUuidType->convertToDatabaseValue($value, $platform);

        $this->assertSame($expectedBinaryValue, $binaryValue);
    }

    public function testConvertToPHPValue(): void
    {
        $platform = $this->createMock(AbstractPlatform::class);
        $uuid = $this->transformer->transformFromSymfonyUuid(
            $this->symfonyUuidFactory->create()
        );
        $binaryValue = $uuid->toBinary();

        $transformedUuid =
            $this->domainUuidType->convertToPHPValue($binaryValue, $platform);

        $this->assertEquals($uuid, $transformedUuid);
    }
}
