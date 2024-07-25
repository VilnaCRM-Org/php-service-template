<?php

namespace App\Eternal\HealthCheck\Domain\Event;

use App\Shared\Domain\Bus\Event\DomainEvent;

final class HealthCheckSuccessEvent extends DomainEvent
{
    private string $checkType;

    public function __construct(string $eventId, string $checkType, ?string $occurredOn = null)
    {
        parent::__construct($eventId, $occurredOn);
        $this->checkType = $checkType;
    }

    public static function fromPrimitives(array $body, string $eventId, string $occurredOn): self
    {
        return new self(
            $eventId,
            $body['checkType'],
            $occurredOn
        );
    }

    public static function eventName(): string
    {
        return 'health_check.success';
    }

    public function toPrimitives(): array
    {
        return [
            'checkType' => $this->checkType,
        ];
    }

    public function checkType(): string
    {
        return $this->checkType;
    }
}
