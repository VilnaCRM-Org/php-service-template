<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Bus\Event;

use App\Shared\Domain\Bus\Event\DomainEvent;
use App\Shared\Domain\Bus\Event\DomainEventSubscriber;
use App\Shared\Domain\Bus\Event\EventBus;
use App\Shared\Infrastructure\Bus\MessageBusFactory;
use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Symfony\Component\Messenger\Exception\NoHandlerForMessageException;
use Symfony\Component\Messenger\MessageBus;

final class InMemorySymfonyEventBus implements EventBus
{
    private readonly MessageBus $bus;

    /**
     * @param iterable<DomainEventSubscriber> $subscribers
     */
    public function __construct(
        MessageBusFactory $busFactory,
        iterable $subscribers
    ) {
        $this->bus = $busFactory->create($subscribers);
    }

    public function publish(DomainEvent ...$events): void
    {
        foreach ($events as $event) {
            try {
                $this->bus->dispatch($event);
            } catch (NoHandlerForMessageException) {
                throw new EventNotRegistered($event);
            } catch (HandlerFailedException $error) {
                throw $error->getPrevious() ?? $error;
            }
        }
    }
}
