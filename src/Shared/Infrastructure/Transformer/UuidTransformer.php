<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Transformer;

use App\Shared\Domain\Factory\UuidFactoryInterface;
use App\Shared\Domain\ValueObject\Uuid;
use Symfony\Component\Uid\AbstractUid as SymfonyUuid;

final readonly class UuidTransformer
{
    public function __construct(
        private UuidFactoryInterface $uuidFactory
    ) {
    }

    public function transformFromSymfonyUuid(SymfonyUuid $symfonyUuid): Uuid
    {
        return $this->createUuid((string) $symfonyUuid);
    }

    public function transformFromString(string $uuid): Uuid
    {
        return $this->createUuid($uuid);
    }

    private function createUuid(string $uuid): Uuid
    {
        return $this->uuidFactory->create($uuid);
    }
}
