<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Bus\Command;

use App\Shared\Domain\Bus\Command\CommandBusInterface;
use App\Shared\Domain\Bus\Command\CommandHandlerInterface;
use App\Shared\Domain\Bus\Command\CommandInterface;
use App\Shared\Infrastructure\Bus\MessageBusFactory;
use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Symfony\Component\Messenger\Exception\NoHandlerForMessageException;
use Symfony\Component\Messenger\MessageBus;

final class InMemorySymfonyCommandBusInterface implements CommandBusInterface
{
    private MessageBus $bus;

    /**
     * Constructor for InMemorySymfonyCommandBus.
     *
     * @param iterable<CommandHandlerInterface> $commandHandlers
     */
    public function __construct(
        MessageBusFactory $busFactory,
        iterable $commandHandlers
    ) {
        $this->bus = $busFactory->create($commandHandlers);
    }

    /**
     * Dispatches a command to the appropriate handler.
     *
     * @param CommandInterface $command Command to be dispatched.
     *
     * @throws \Throwable Throws an exception if handling fails.
     */
    public function dispatch(CommandInterface $command): void
    {
        try {
            $this->bus->dispatch($command);
        } catch (NoHandlerForMessageException) {
            $this->handleNoHandlerException($command);
        } catch (HandlerFailedException $exception) {
            $this->rethrowException($exception);
        }
    }

    /**
     * Handle cases where no handler is registered for the command.
     *
     * @param CommandInterface $command Command that lacks a handler.
     */
    private function handleNoHandlerException(CommandInterface $command): void
    {
        throw new CommandNotRegisteredException($command);
    }

    /**
     * Rethrow the underlying exception from a failed handler.
     *
     * @param HandlerFailedException $exception Exception to process.
     */
    private function rethrowException(HandlerFailedException $exception): void
    {
        throw $exception->getPrevious() ?? $exception;
    }
}
