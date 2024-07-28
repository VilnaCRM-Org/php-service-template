<?php

declare(strict_types=1);

namespace App\Shared\Domain\Bus\Event;

abstract class DomainEvent
{
    private readonly string $eventId;
    private readonly string $occurredOn;

    public function __construct(string $eventId, ?string $occurredOn)
    {
        $this->eventId = $eventId;
        $this->occurredOn = $occurredOn ??
            self::dateToString(new \DateTimeImmutable());
    }

    /**
     * @param array<string, string|object> $body
     */
    abstract public static function fromPrimitives(
        array $body,
        string $eventId,
        string $occurredOn
    ): self;

    abstract public static function eventName(): string;

    /**
     * @return array<string, string|object>
     */
    abstract public function toPrimitives(): array;

    public function eventId(): string
    {
        return $this->eventId;
    }

    public function occurredOn(): string
    {
        return $this->occurredOn;
    }

    private function dateToString(\DateTimeInterface $date): string
    {
        return $date->format(\DateTimeInterface::ATOM);
    }
}
