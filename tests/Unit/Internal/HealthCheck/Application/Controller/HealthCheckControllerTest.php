<?php

declare(strict_types=1);

namespace App\Tests\Unit\Internal\HealthCheck\Application\Controller;

use App\Internal\HealthCheck\Application\Controller\HealthCheckController;
use App\Internal\HealthCheck\Domain\Event\HealthCheckEvent;
use App\Internal\HealthCheck\Infrastructure\Factory\Event\HealthEventFactory;
use App\Tests\Unit\UnitTestCase;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Response;

final class HealthCheckControllerTest extends UnitTestCase
{
    private EventDispatcherInterface $eventDispatcher;
    private HealthEventFactory $eventFactory;
    private HealthCheckController $controller;

    protected function setUp(): void
    {
        parent::setUp();

        $this->eventDispatcher = $this->createMock(
            EventDispatcherInterface::class
        );
        $this->eventFactory = $this->createMock(
            HealthEventFactory::class
        );
        $this->controller = new HealthCheckController(
            $this->eventDispatcher,
            $this->eventFactory
        );
    }

    public function testInvokeDispatchesHealthCheckEvent(): void
    {
        $healthCheckEvent = new HealthCheckEvent();

        $this->eventFactory->expects($this->once())
            ->method('createHealthCheckEvent')
            ->willReturn($healthCheckEvent);

        $this->eventDispatcher->expects($this->once())
            ->method('dispatch')
            ->with(
                $this->isInstanceOf(HealthCheckEvent::class),
                HealthCheckEvent::class
            );

        $response = ($this->controller)();

        $this->assertInstanceOf(Response::class, $response);
        $this->assertEquals(
            Response::HTTP_NO_CONTENT,
            $response->getStatusCode()
        );
    }
}
