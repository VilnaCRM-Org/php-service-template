<?php

declare(strict_types=1);

namespace App\Tests\Unit\Shared\Domain\Aggregate;

use App\Shared\Domain\Aggregate\AggregateRoot;
use App\Shared\Domain\Bus\Event\DomainEvent;
use PHPUnit\Framework\TestCase;

final class AggregateRootTest extends TestCase
{
    public function testPullDomainEvents(): void
    {
        $event1 = $this->createMock(DomainEvent::class);
        $event2 = $this->createMock(DomainEvent::class);

        $aggregateRoot = new class() extends AggregateRoot {
            /**
             * @return array<DomainEvent>
             */
            public function getDomainEvents(): array
            {
                return $this->pullDomainEvents();
            }

            public function recordEvent(DomainEvent $event): void
            {
                $this->record($event);
            }
        };

        $aggregateRoot->recordEvent($event1);
        $aggregateRoot->recordEvent($event2);

        $domainEvents = $aggregateRoot->getDomainEvents();

        $this->assertCount(2, $domainEvents);
        $this->assertSame($event1, $domainEvents[0]);
        $this->assertSame($event2, $domainEvents[1]);
    }

    public function testPullDomainEventsFromOutside(): void
    {
        $event1 = $this->createMock(DomainEvent::class);
        $event2 = $this->createMock(DomainEvent::class);

        $aggregateRoot = new class() extends AggregateRoot {
            public function recordEvent(DomainEvent $event): void
            {
                $this->record($event);
            }
        };

        $aggregateRoot->recordEvent($event1);
        $aggregateRoot->recordEvent($event2);

        $domainEvents = $aggregateRoot->pullDomainEvents();

        $this->assertCount(2, $domainEvents);
        $this->assertSame($event1, $domainEvents[0]);
        $this->assertSame($event2, $domainEvents[1]);
    }
}
