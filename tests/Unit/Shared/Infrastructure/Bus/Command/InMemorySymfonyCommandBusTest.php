<?php

declare(strict_types=1);

namespace App\Tests\Unit\Shared\Infrastructure\Bus\Command;

use App\Shared\Domain\Bus\Command\CommandInterface;
use App\Shared\Infrastructure\Bus\Command\CommandNotRegisteredException;
use App\Shared\Infrastructure\Bus\Command\InMemorySymfonyCommandBus;
use App\Shared\Infrastructure\Bus\MessageBusFactory;
use App\Tests\Unit\UnitTestCase;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Symfony\Component\Messenger\Exception\NoHandlerForMessageException;
use Symfony\Component\Messenger\MessageBus;

final class InMemorySymfonyCommandBusTest extends UnitTestCase
{
    private MessageBusFactory $messageBusFactory;
    private array $commandHandlers;

    protected function setUp(): void
    {
        parent::setUp();
        $this->messageBusFactory = $this->createMock(MessageBusFactory::class);
        $this->commandHandlers = [$this->createMock(CommandInterface::class)];
    }

    public function testDispatchWithNoHandlerForMessageException(): void
    {
        $command = $this->createMock(CommandInterface::class);
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

        $this->expectException(CommandNotRegisteredException::class);
        $commandBus->dispatch($command);
    }

    public function testDispatchWithHandlerFailedExceptionWithInnerException(): void
    {
        $command = $this->createMock(CommandInterface::class);
        $envelope = new Envelope($command);
        $innerException = new \Exception("Inner exception");
        $handlerFailedException = new HandlerFailedException($envelope, [$innerException]);

        $messageBus = $this->createMock(MessageBus::class);
        $messageBus->expects($this->once())
            ->method('dispatch')
            ->willThrowException($handlerFailedException);

        $this->messageBusFactory->method('create')
            ->willReturn($messageBus);

        $commandBus = new InMemorySymfonyCommandBus(
            $this->messageBusFactory,
            $this->commandHandlers
        );

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage("Inner exception");
        $commandBus->dispatch($command);
    }

    public function testDispatchWithHandlerFailedExceptionWithoutInnerException(): void
    {
        $command = $this->createMock(CommandInterface::class);
        $envelope = new Envelope($command);
        $dummyException = new \RuntimeException("No handlers executed");
        $handlerFailedException = new HandlerFailedException($envelope, [$dummyException]);

        $messageBus = $this->createMock(MessageBus::class);
        $messageBus->expects($this->once())
            ->method('dispatch')
            ->willThrowException($handlerFailedException);

        $this->messageBusFactory->method('create')
            ->willReturn($messageBus);

        $commandBus = new InMemorySymfonyCommandBus(
            $this->messageBusFactory,
            $this->commandHandlers
        );

        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage("No handlers executed");
        $commandBus->dispatch($command);
    }

    public function testDispatchExecutesSuccessfully(): void
    {
        $command = $this->createMock(CommandInterface::class);
        $messageBus = $this->createMock(MessageBus::class);

        $messageBus->expects($this->once())
            ->method('dispatch')
            ->with($this->equalTo($command));

        $this->messageBusFactory->method('create')
            ->willReturn($messageBus);

        $commandBus = new InMemorySymfonyCommandBus(
            $this->messageBusFactory,
            $this->commandHandlers
        );

        $commandBus->dispatch($command);
    }
}
