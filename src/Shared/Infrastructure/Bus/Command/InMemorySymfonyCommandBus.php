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
use Throwable;

final class InMemorySymfonyCommandBus implements CommandBusInterface
{
    private MessageBus $bus;

    /**
     * @param iterable<CommandHandlerInterface> $commandHandlers
     */
    public function __construct(
        MessageBusFactory $busFactory,
        iterable $commandHandlers
    ) {
        $this->bus = $busFactory->create($commandHandlers);
    }

    /**
     * @throws Throwable
     */
    public function dispatch(CommandInterface $command): void
    {
        $this->executeDispatch(
            fn () => $this->bus->dispatch($command),
            $command
        );
    }

    /**
     * Handles the dispatch logic and exception
     * handling using a higher-order function.
     */
    private function executeDispatch(
        callable $dispatchAction,
        CommandInterface $command
    ): void {
        try {
            $dispatchAction();
        } catch (HandlerFailedException $exception) {
            $this->handleException($exception, $command);
        }
    }

    /**
     * Decides which exception to throw based on the type of error encountered.
     *
     * @throws Throwable
     */
    private function handleException(
        HandlerFailedException $exception,
        CommandInterface $command
    ): void {
        $previous = $exception->getPrevious();

        throw match (true) {
            $this->isNoHandlerEx($previous) => $this->createException($command),
            default => $previous ?? $exception,
        };
    }

    private function isNoHandlerEx(?Throwable $exception): bool
    {
        return $exception instanceof NoHandlerForMessageException;
    }

    private function createException(
        CommandInterface $command
    ): CommandNotRegisteredException {
        return new CommandNotRegisteredException($command);
    }
}
