<?php

declare(strict_types=1);

namespace App\Tests\Unit\Shared\Domain\Bus;

use App\Shared\Domain\Bus\Event\DomainEvent;
use App\Tests\Unit\UnitTestCase;

final class DomainEventTest extends UnitTestCase
{
    public function testConstructWithProvidedDate(): void
    {
        $eventId = 'event-id';
        $occurredOn = '2023-07-24';

        $event = $this->getMockForAbstractClass(
            DomainEvent::class,
            [$eventId, $occurredOn]
        );
        $this->assertEquals($occurredOn, $event->occurredOn());
    }

    public function testEventIdIsAccessibleAndCorrect(): void
    {
        $eventId = 'event-id';
        $occurredOn = '2023-07-24';

        $event = $this->getMockForAbstractClass(
            DomainEvent::class,
            [$eventId, $occurredOn]
        );

        $this->assertEquals(
            $eventId,
            $event->eventId(),
            'The event ID should be accessible publicly
             and match the expected value.'
        );
    }

    public function testConstructWithoutProvidedDate(): void
    {
        $eventId = 'event-id';
        $event = $this->getMockForAbstractClass(
            DomainEvent::class,
            [$eventId, null]
        );

        $expectedDate = (new \DateTimeImmutable())->format(
            'Y-m-d\TH:i:s+00:00'
        );
        $this->assertEquals($expectedDate, $event->occurredOn());
    }
}
