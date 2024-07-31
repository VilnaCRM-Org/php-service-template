<?php

declare(strict_types=1);

namespace App\Shared\Application\Transformer;

use App\Shared\Domain\ValueObject\Uuid;
use Symfony\Component\Uid\AbstractUid as SymfonyUuid;

final class UuidTransformer
{
    public function transformFromSymfonyUuid(SymfonyUuid $symfonyUuid): Uuid
    {
        return new Uuid((string) $symfonyUuid);
    }

    public function transformFromString(string $uuid): Uuid
    {
        return new Uuid($uuid);
    }
}
