<?php

declare(strict_types=1);

namespace App\Tests\Unit\Internal\HealthCheck\Domain\Factory\Event;

use App\Internal\HealthCheck\Domain\Event\HealthCheckEvent;
use App\Internal\HealthCheck\Infrastructure\Factory\Event\HealthEventFactory;
use App\Tests\Unit\UnitTestCase;

final class HealthEventFactoryTest extends UnitTestCase
{
    private HealthEventFactory $factory;

    protected function setUp(): void
    {
        parent::setUp();

        $this->factory = new HealthEventFactory();
    }

    public function testCreateHealthCheckEvent(): void
    {
        $event = $this->factory->createHealthCheckEvent();

        $this->assertInstanceOf(HealthCheckEvent::class, $event);
    }

    public function testCreateHealthCheckEventDoesNotThrowException(): void
    {
        $this->expectNotToPerformAssertions();

        $this->factory->createHealthCheckEvent();
    }
}
