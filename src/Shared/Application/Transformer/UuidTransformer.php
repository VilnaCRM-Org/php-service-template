<?php

declare(strict_types=1);

namespace App\Shared\Application\Transformer;

use App\Shared\Domain\ValueObject\UuidImpl;
use Symfony\Component\Uid\AbstractUid as SymfonyUuid;

final class UuidTransformer
{
    public function transformFromSymfonyUuid(SymfonyUuid $symfonyUuid): UuidImpl
    {
        return new UuidImpl((string) $symfonyUuid);
    }

    public function transformFromString(string $uuid): UuidImpl
    {
        return new UuidImpl($uuid);
    }
}
