<?php

declare(strict_types=1);

namespace App\Tests\Unit\Shared\Infrastructure\Bus\Event;

use App\Shared\Domain\Bus\Event\DomainEvent;
use App\Shared\Infrastructure\Bus\Event\EventNotRegisteredException;
use App\Shared\Infrastructure\Bus\Event\InMemorySymfonyEventBus;
use App\Shared\Infrastructure\Bus\MessageBusFactory;
use App\Tests\Unit\UnitTestCase;
use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Symfony\Component\Messenger\Exception\NoHandlerForMessageException;
use Symfony\Component\Messenger\MessageBus;

final class InMemorySymfonyEventBusTest extends UnitTestCase
{
    private MessageBusFactory $messageBusFactory;

    /**
     * @var array<DomainEvent>
     */
    private array $eventSubscribers;

    protected function setUp(): void
    {
        parent::setUp();
        $this->messageBusFactory =
            $this->createMock(MessageBusFactory::class);
        $this->eventSubscribers =
            [$this->createMock(DomainEvent::class)];
    }

    public function testDispatchWithNoHandlerForMessageException(): void
    {
        $event = $this->createMock(DomainEvent::class);
        $messageBus = $this->createMock(MessageBus::class);
        $messageBus->expects($this->once())
            ->method('dispatch')
            ->willThrowException(new NoHandlerForMessageException());
        $this->messageBusFactory->method('create')
            ->willReturn($messageBus);
        $eventBus = new InMemorySymfonyEventBus(
            $this->messageBusFactory,
            $this->eventSubscribers
        );

        $this->expectException(EventNotRegisteredException::class);

        $eventBus->publish($event);
    }

    public function testDispatchWithHandlerFailedException(): void
    {
        $event = $this->createMock(DomainEvent::class);
        $messageBus = $this->createMock(MessageBus::class);
        $messageBus->expects($this->once())
            ->method('dispatch')
            ->willThrowException(
                $this->createMock(HandlerFailedException::class)
            );
        $this->messageBusFactory->method('create')
            ->willReturn($messageBus);
        $eventBus = new InMemorySymfonyEventBus(
            $this->messageBusFactory,
            $this->eventSubscribers
        );

        $this->expectException(HandlerFailedException::class);

        $eventBus->publish($event);
    }

    public function testDispatchWithThrowable(): void
    {
        $event = $this->createMock(DomainEvent::class);
        $messageBus = $this->createMock(MessageBus::class);
        $messageBus->expects($this->once())
            ->method('dispatch')
            ->willThrowException(new \RuntimeException());
        $this->messageBusFactory->method('create')
            ->willReturn($messageBus);
        $eventBus = new InMemorySymfonyEventBus(
            $this->messageBusFactory,
            $this->eventSubscribers
        );

        $this->expectException(\RuntimeException::class);

        $eventBus->publish($event);
    }
}
