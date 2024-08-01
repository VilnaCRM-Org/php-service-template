<?php

declare(strict_types=1);

namespace App\Tests\Unit\Internal\HealthCheck\Domain\Factory\Event;

use App\Internal\HealthCheck\Domain\Event\HealthCheckEvent;
use App\Internal\HealthCheck\Domain\Factory\Event\HealthCheckEventFactory;
use App\Tests\Unit\UnitTestCase;

final class HealthCheckEventFactoryTest extends UnitTestCase
{
    private HealthCheckEventFactory $factory;

    protected function setUp(): void
    {
        parent::setUp();

        $this->factory = new HealthCheckEventFactory();
    }

    public function testCreateHealthCheckEvent(): void
    {
        $event = $this->factory->createHealthCheckEvent();

        $this->assertInstanceOf(HealthCheckEvent::class, $event);
    }
}
