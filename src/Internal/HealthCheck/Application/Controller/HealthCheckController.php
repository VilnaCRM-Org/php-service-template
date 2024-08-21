<?php

declare(strict_types=1);

namespace App\Internal\HealthCheck\Application\Controller;

use App\Internal\HealthCheck\Domain\Event\HealthCheckEvent;
use App\Internal\HealthCheck\Infrastructure\Factory\Event\HealthEventFactory;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Response;

final class HealthCheckController extends AbstractController
{
    private EventDispatcherInterface $eventDispatcher;
    private HealthEventFactory $eventFactory;

    public function __construct(
        EventDispatcherInterface $eventDispatcher,
        HealthEventFactory $eventFactory
    ) {
        $this->eventDispatcher = $eventDispatcher;
        $this->eventFactory = $eventFactory;
    }

    public function __invoke(): Response
    {
        $event = $this->eventFactory->createHealthCheckEvent();
        $this->eventDispatcher->dispatch($event, HealthCheckEvent::class);

        return new Response(status: Response::HTTP_NO_CONTENT);
    }
}
