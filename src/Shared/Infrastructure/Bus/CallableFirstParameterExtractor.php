<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Bus;

use App\Shared\Domain\Bus\Event\DomainEventSubscriber;

use function Lambdish\Phunctional\map;
use function Lambdish\Phunctional\reduce;
use function Lambdish\Phunctional\reindex;

final class CallableFirstParameterExtractor
{
    /**
     * @param iterable<DomainEventSubscriber> $callables
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
     * @param iterable<DomainEventSubscriber> $callables
     *
     * @return array<int, array<DomainEventSubscriber>>
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

    private static function classExtractor(
        CallableFirstParameterExtractor $parameterExtractor
    ): callable {
        return static fn (callable $handler): ?string => $parameterExtractor->
        extract($handler);
    }

    private static function pipedCallablesReducer(): callable
    {
        return static function (
            $subscribers,
            DomainEventSubscriber $subscriber
        ): array {
            $subscribedEvents = $subscriber->subscribedTo();

            foreach ($subscribedEvents as $subscribedEvent) {
                $subscribers[$subscribedEvent][] = $subscriber;
            }

            return $subscribers;
        };
    }

    private static function unflatten(): callable
    {
        return static fn ($value) => [$value];
    }

    private function firstParameterClassFrom(\ReflectionMethod $method): string
    {
        /** @var \ReflectionNamedType $fistParameterType */
        $fistParameterType = $method->getParameters()[0]->getType();

        if ($fistParameterType === null) {
            throw new \LogicException(
                'Missing type hint for the first parameter of __invoke'
            );
        }

        return $fistParameterType->getName();
    }

    private function hasOnlyOneParameter(\ReflectionMethod $method): bool
    {
        return $method->getNumberOfParameters() === 1;
    }
}
