<?php

namespace App\Internal\HealthCheck\Application\Controller;

use App\Internal\HealthCheck\Domain\Event\HealthCheckEvent;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Response;

class HealthCheckController extends AbstractController
{
    private EventDispatcherInterface $eventDispatcher;

    public function __construct(EventDispatcherInterface $eventDispatcher)
    {
        $this->eventDispatcher = $eventDispatcher;
    }

    public function __invoke(): Response
    {
        $event = new HealthCheckEvent();
        $this->eventDispatcher->dispatch($event, HealthCheckEvent::class);

        return new Response(status: Response::HTTP_NO_CONTENT);
    }
}
