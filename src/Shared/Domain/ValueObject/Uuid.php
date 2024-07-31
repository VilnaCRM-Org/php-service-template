<?php

declare(strict_types=1);

namespace App\Shared\Domain\ValueObject;

final class Uuid implements UuidInterface
{
    private string $uid;

    public function __construct(string $uid)
    {
        $this->uid = $uid;
    }

    public function __toString(): string
    {
        return $this->uid;
    }

    public function toBinary(): ?string
    {
        return $this->isConvertableToBinary($this->uid) ?
            hex2bin(str_replace('-', '', $this->uid)) : null;
    }

    private function isConvertableToBinary(string $uid): bool
    {
        return strlen($uid) % 2 === 0;
    }
}
