<?php

declare(strict_types=1);

namespace App\Tests\Unit\Shared\Infrastructure\Bus\Command;

use App\Shared\Domain\Bus\Command\Command;
use App\Shared\Infrastructure\Bus\Command\CommandNotRegistered;
use App\Shared\Infrastructure\Bus\Command\InMemorySymfonyCommandBus;
use App\Shared\Infrastructure\Bus\MessageBusFactory;
use App\Tests\Unit\UnitTestCase;
use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Symfony\Component\Messenger\Exception\NoHandlerForMessageException;
use Symfony\Component\Messenger\MessageBus;

final class InMemorySymfonyCommandBusTest extends UnitTestCase
{
    private MessageBusFactory $messageBusFactory;

    /**
     * @var array<Command>
     */
    private array $commandHandlers;

    protected function setUp(): void
    {
        parent::setUp();
        $this->messageBusFactory =
            $this->createMock(MessageBusFactory::class);
        $this->commandHandlers =
            [$this->createMock(Command::class)];
    }

    public function testDispatchWithNoHandlerForMessageException(): void
    {
        $command = $this->createMock(Command::class);
        $messageBus = $this->createMock(MessageBus::class);
        $messageBus->expects($this->once())
            ->method('dispatch')
            ->willThrowException(new NoHandlerForMessageException());
        $this->messageBusFactory->method('create')
            ->willReturn($messageBus);
        $commandBus = new InMemorySymfonyCommandBus(
            $this->messageBusFactory,
            $this->commandHandlers
        );

        $this->expectException(CommandNotRegistered::class);

        $commandBus->dispatch($command);
    }

    public function testDispatchWithHandlerFailedException(): void
    {
        $command = $this->createMock(Command::class);
        $messageBus = $this->createMock(MessageBus::class);
        $messageBus->expects($this->once())
            ->method('dispatch')
            ->willThrowException(
                $this->createMock(HandlerFailedException::class)
            );
        $this->messageBusFactory->method('create')
            ->willReturn($messageBus);
        $commandBus = new InMemorySymfonyCommandBus(
            $this->messageBusFactory,
            $this->commandHandlers
        );

        $this->expectException(HandlerFailedException::class);

        $commandBus->dispatch($command);
    }

    public function testDispatchWithThrowable(): void
    {
        $command = $this->createMock(Command::class);
        $messageBus = $this->createMock(MessageBus::class);
        $messageBus->expects($this->once())
            ->method('dispatch')
            ->willThrowException(new \RuntimeException());
        $this->messageBusFactory->method('create')
            ->willReturn($messageBus);
        $commandBus = new InMemorySymfonyCommandBus(
            $this->messageBusFactory,
            $this->commandHandlers
        );

        $this->expectException(\RuntimeException::class);

        $commandBus->dispatch($command);
    }
}
