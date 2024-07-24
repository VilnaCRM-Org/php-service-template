<?php

declare(strict_types=1);

namespace App\Tests\Unit\Shared\Infrastructure\Bus;

use App\Shared\Domain\Bus\Event\DomainEvent;
use App\Shared\Domain\Bus\Event\DomainEventSubscriberInterface;
use App\Shared\Infrastructure\Bus\CallableFirstParameterExtractor;
use App\Tests\Unit\UnitTestCase;

final class CallableFirstParameterExtractorTest extends UnitTestCase
{
    private CallableFirstParameterExtractor $extractor;

    protected function setUp(): void
    {
        $this->extractor = new CallableFirstParameterExtractor();
    }

    public function testExtractForCallables(): void
    {
        $subscriber = new class() implements DomainEventSubscriberInterface {
            /**
             * @return array<string>
             */
            public function subscribedTo(): array
            {
                return ['MyEvent'];
            }

            public function __invoke(): void
            {
                // This method is intentionally left empty because it serves as a placeholder.
                // In this specific context, __invoke allows the object to be called as a function.
            }
        };

        $callables = [$subscriber];

        $expected = ['' => $callables];

        $extracted = $this->extractor->forCallables($callables);

        $this->assertEquals($expected, $extracted);
    }

    public function testExtractForPipedCallables(): void
    {
        $className1 = 'MyEvent1';
        $className2 = 'MyEvent2';
        $subscriber1 = $this->getSubscriberWithEmptyInvoke($className1);
        $subscriber2 = $this->getSubscriberWithEmptyInvoke($className2);

        $callables = [$subscriber1, $subscriber2];

        $expected = [
            $className1 => [$subscriber1],
            $className2 => [$subscriber2],
        ];

        $extracted = $this->extractor->forPipedCallables($callables);

        $this->assertEquals($expected, $extracted);
    }

    public function testExtract(): void
    {
        $subscriberClass =
            new class() implements DomainEventSubscriberInterface {
                /**
                 * @return array<string>
                 */
                public function subscribedTo(): array
                {
                    return [DomainEvent::class];
                }

                public function __invoke(DomainEvent $someClass): void
                {
                    // This method is intentionally left empty because it serves as a placeholder.
                    // In this specific context, __invoke allows the object to be called as a function.
                }
            };

        $extracted = $this->extractor->extract($subscriberClass);

        $this->assertEquals(DomainEvent::class, $extracted);
    }

    public function testExtractWithError(): void
    {
        $subscriberClass =
            new class() implements DomainEventSubscriberInterface {
                /**
                 * @return array<string>
                 */
                public function subscribedTo(): array
                {
                    return ['MyEvent'];
                }

                public function __invoke($someClass): void
                {
                    // This method is intentionally left empty because it serves as a placeholder.
                    // In this specific context, __invoke allows the object to be called as a function.
                }
            };

        $this->expectException(\LogicException::class);

        $this->extractor->extract($subscriberClass);
    }

    private function getSubscriberWithEmptyInvoke(
        string $class
    ): callable|DomainEventSubscriberInterface {
        return new class($class) implements DomainEventSubscriberInterface {
            public function __construct(private string $subscribedTo)
            {
            }

            /**
             * @return array<string>
             */
            public function subscribedTo(): array
            {
                return [$this->subscribedTo];
            }

            public function __invoke(): void
            {
                // This method is intentionally left empty because it serves as a placeholder.
                // In this specific context, __invoke allows the object to be called as a function.
            }
        };
    }
}
