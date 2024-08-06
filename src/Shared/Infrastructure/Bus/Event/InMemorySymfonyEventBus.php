<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Bus\Event;

use App\Shared\Domain\Bus\Event\DomainEvent;
use App\Shared\Domain\Bus\Event\DomainEventSubscriberInterface;
use App\Shared\Domain\Bus\Event\EventBusInterface;
use App\Shared\Infrastructure\Bus\MessageBusFactory;
use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Symfony\Component\Messenger\Exception\NoHandlerForMessageException;
use Symfony\Component\Messenger\MessageBus;

final class InMemorySymfonyEventBus implements EventBusInterface
{
    private readonly MessageBus $bus;

    /**
     * @param iterable<DomainEventSubscriberInterface> $subscribers
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
                throw new EventNotRegisteredException($event);
            } catch (HandlerFailedException $error) {
                throw $error->getPrevious() ?? $error;
            }
        }
    }
}
