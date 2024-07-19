<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Bus;

use Symfony\Component\Messenger\Handler\HandlersLocator;
use Symfony\Component\Messenger\MessageBus;
use Symfony\Component\Messenger\Middleware\HandleMessageMiddleware;

final class MessageBusFactory
{
    /**
     * @param iterable<object> $callables
     */
    public function create(iterable $callables): MessageBus
    {
        return new MessageBus([$this->getMiddleWare($callables)]);
    }

    /**
     * @param iterable<object> $callables
     */
    private function getMiddleWare(iterable $callables): HandleMessageMiddleware
    {
        return new HandleMessageMiddleware(
            new HandlersLocator(
                CallableFirstParameterExtractor::forCallables(
                    $callables
                )
            )
        );
    }
}
