<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Bus;

use App\Shared\Domain\Bus\Event\DomainEventSubscriberInterface;

use function Lambdish\Phunctional\map;
use function Lambdish\Phunctional\reduce;
use function Lambdish\Phunctional\reindex;

final class CallableFirstParameterExtractor
{
    /**
     * @param iterable<DomainEventSubscriberInterface> $callables
     *
     * @return array<int, string|null>
     */
    public static function forCallables(iterable $callables): array
    {
        return map(
            self::unflatten(),
            reindex(self::classExtractor(new self()), $callables)
        );
    }

    /**
     * @param iterable<DomainEventSubscriberInterface> $callables
     *
     * @return array<int, array<DomainEventSubscriberInterface>>
     */
    public static function forPipedCallables(iterable $callables): array
    {
        return reduce(self::pipedCallablesReducer(), $callables, []);
    }

    public function extract(object|string $class): ?string
    {
        $reflector = new \ReflectionClass($class);
        $method = $reflector->getMethod('__invoke');

        if ($this->hasOnlyOneParameter($method)) {
            return $this->firstParameterClassFrom($method);
        }

        return null;
    }

    private static function classExtractor(self $parameterExtractor): callable
    {
        return static fn (callable $handler): ?string => self::extractHandler(
            $parameterExtractor,
            $handler
        );
    }
    private static function extractHandler(
        self $parameterExtractor,
        callable $handler
    ): ?string {
        return $parameterExtractor->extract($handler);
    }
    /**
     * @return array<int, array<DomainEventSubscriberInterface>>
     */
    private static function pipedCallablesReducer(): callable
    {
        return static fn (
            array $subscribers,
            DomainEventSubscriberInterface $subscriber
        ): array => array_reduce(
            $subscriber->subscribedTo(),
            static fn (
                array $carry,
                string $event
            ) => self::addSubscriberToEvent($carry, $event, $subscriber),
            $subscribers
        );
    }

    /**
     * @param array<DomainEventSubscriberInterface> $subscribers
     *
     * @return array<int, array<DomainEventSubscriberInterface>>
     */
    private static function addSubscriberToEvent(
        array $subscribers,
        string $event,
        DomainEventSubscriberInterface $subscriber
    ): array {
        $subscribers[$event][] = $subscriber;
        return $subscribers;
    }

    private static function unflatten(): callable
    {
        return static fn ($value) => [$value];
    }

    private function firstParameterClassFrom(\ReflectionMethod $method): string
    {
        /** @var \ReflectionNamedType $firstParameterType */
        $firstParameterType = $method->getParameters()[0]->getType();

        if ($firstParameterType === null) {
            throw new \LogicException(
                'Missing type hint for the first parameter of __invoke'
            );
        }

        return $firstParameterType->getName();
    }

    private function hasOnlyOneParameter(\ReflectionMethod $method): bool
    {
        return $method->getNumberOfParameters() === 1;
    }
}
