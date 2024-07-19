<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\DoctrineType;

use App\Shared\Application\Transformer\UuidTransformer;
use App\Shared\Domain\ValueObject\Uuid;
use App\Shared\Domain\ValueObject\UuidInterface;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;
use Symfony\Bridge\Doctrine\Types\UuidType;

final class DomainUuidType extends Type
{
    public const NAME = 'domain_uuid';

    public function getName(): string
    {
        return self::NAME;
    }

    /**
     * @param array<string|object> $column
     */
    public function getSQLDeclaration(
        array $column,
        AbstractPlatform $platform
    ): string {
        $symfonyType = $this->getSymfonyUuidType();

        return $symfonyType->getSQLDeclaration($column, $platform);
    }

    public function convertToDatabaseValue(
        mixed $value,
        AbstractPlatform $platform
    ): ?string {
        if ($value instanceof UuidInterface) {
            return $value->toBinary();
        }

        $uuid = new Uuid($value);

        return $uuid->toBinary();
    }

    public function convertToPHPValue(
        mixed $value,
        AbstractPlatform $platform
    ): ?Uuid {
        $symfonyType = $this->getSymfonyUuidType();
        $symfonyUuid = $symfonyType->convertToPHPValue($value, $platform);
        $transformer = new UuidTransformer();

        return $transformer->transformFromSymfonyUuid($symfonyUuid);
    }

    private function getSymfonyUuidType(): UuidType
    {
        return new UuidType();
    }
}
