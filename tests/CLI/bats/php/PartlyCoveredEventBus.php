<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Bus\Event;

use App\Shared\Domain\Bus\Event\DomainEvent;
use App\Shared\Domain\Bus\Event\EventBus;
use Symfony\Component\Messenger\MessageBus;

final class PartlyCoveredEventBus implements EventBus
{
    private MessageBus $bus;

    public function __construct(MessageBus $bus)
    {
        $this->bus = $bus;
    }

    public function publish(DomainEvent ...$events): void
    {
        foreach ($events as $event) {
            $this->bus->dispatch($event);
        }
    }

    public function getEventCount(array $events): int
    {
        $count = 0;
        foreach ($events as $event) {
            if ($event instanceof DomainEvent) {
                $count++;
            }
        }
        return $count;
    }
}
