<?php

namespace App\Internal\HealthCheck\Domain\Event;

use App\Shared\Domain\Bus\Event\DomainEvent;

final class HealthCheckEvent extends DomainEvent
{
    private $reason;
    private $checkType;

    public function __construct()
    {
    }

    public static function fromPrimitives(array $body, string $eventId, string $occurredOn): self
    {
        return new self(
            $eventId,
            $body['checkType'],
            $body['reason'],
            $occurredOn
        );
    }

    public static function eventName(): string
    {
        return 'health_check.failed';
    }

    public function toPrimitives(): array
    {
        return [
            'checkType' => $this->checkType,
            'reason' => $this->reason,
        ];
    }

    public function checkType(): string
    {
        return $this->checkType;
    }

    public function reason(): string
    {
        return $this->reason;
    }
}
