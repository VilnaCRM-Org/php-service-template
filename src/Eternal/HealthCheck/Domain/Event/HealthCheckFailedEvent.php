<?php

namespace App\Eternal\HealthCheck\Domain\Event;

use App\Shared\Domain\Bus\Event\DomainEvent;

final class HealthCheckFailedEvent extends DomainEvent
{
    private string $checkType;
    private string $reason;

    public function __construct(string $eventId, string $checkType, string $reason, ?string $occurredOn = null)
    {
        parent::__construct($eventId, $occurredOn);
        $this->checkType = $checkType;
        $this->reason = $reason;
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
