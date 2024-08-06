<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Bus\Event;

use App\Shared\Domain\Bus\Event\DomainEvent;

final class EventNotRegisteredException extends \RuntimeException
{
    public function __construct(DomainEvent $event)
    {
        $eventClass = $event::class;

        parent::__construct(
            "The event <{$eventClass}> hasn't an event handler associated"
        );
    }
}
