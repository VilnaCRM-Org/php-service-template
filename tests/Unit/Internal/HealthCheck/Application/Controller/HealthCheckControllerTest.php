<?php

declare(strict_types=1);

namespace App\Tests\Unit\Internal\HealthCheck\Application\Controller;

use App\Internal\HealthCheck\Application\Controller\HealthCheckController;
use App\Internal\HealthCheck\Domain\Event\HealthCheckEvent;
use App\Tests\Unit\UnitTestCase;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Response;

class HealthCheckControllerTest extends UnitTestCase
{
    private EventDispatcherInterface $eventDispatcher;
    private HealthCheckController $controller;

    protected function setUp(): void
    {
        parent::setUp();

        $this->eventDispatcher = $this->createMock(EventDispatcherInterface::class);
        $this->controller = new HealthCheckController($this->eventDispatcher);
    }

    public function testInvokeDispatchesHealthCheckEvent(): void
    {
        $this->eventDispatcher->expects($this->once())
            ->method('dispatch')
            ->with($this->isInstanceOf(HealthCheckEvent::class), HealthCheckEvent::class);

        $response = ($this->controller)();

        $this->assertInstanceOf(Response::class, $response);
        $this->assertEquals(Response::HTTP_NO_CONTENT, $response->getStatusCode());
    }
}
