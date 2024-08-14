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

class InMemorySymfonyCommandBus implements CommandBusInterface
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

    public function dispatch(CommandInterface $command): void
    {
        try {
            $this->bus->dispatch($command);
        } catch (\Throwable $error) {
            throw $this->handleError($error, $command);
        }
    }

    private function handleError(
        \Throwable $error,
        CommandInterface $command
    ): \Throwable {
        $errorMap = [
            NoHandlerForMessageException::class => static fn (

            ) => new CommandNotRegisteredException($command),
            HandlerFailedException::class => static fn (
                $e
            ) => $e->getPrevious() ?? $e,
        ];

        return $errorMap[$error::class]($error) ?? $error;
    }
}
