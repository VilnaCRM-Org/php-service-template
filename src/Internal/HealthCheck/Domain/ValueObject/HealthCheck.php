<?php

namespace App\Internal\HealthCheck\Domain\ValueObject;

class HealthCheck
{
    private bool $status;

    public function __construct(bool $status)
    {
        $this->status = $status;
    }

    public function getStatus(): bool
    {
        return $this->status;
    }
}
