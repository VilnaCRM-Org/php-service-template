<?php

declare(strict_types=1);

namespace App\Internal\HealthCheck\Application\Processor;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Internal\HealthCheck\Domain\Factory\Event\EventFactoryInterface;
use App\Shared\Domain\Bus\Event\EventBusInterface;
use Symfony\Component\HttpFoundation\Response;

/**
 * @implements ProcessorInterface<mixed, Response>
 */
final class HealthCheckProcessor implements ProcessorInterface
{
    private EventFactoryInterface $eventFactory;
    private EventBusInterface $eventBus;

    public function __construct(
        EventFactoryInterface $eventFactory,
        EventBusInterface $eventBus
    ) {
        $this->eventFactory = $eventFactory;
        $this->eventBus = $eventBus;
    }

    /**
     * @param array<string, string> $uriVariables
     * @param array<string, mixed>  $context
     */
    public function process(
        mixed $data,
        Operation $operation,
        array $uriVariables = [],
        array $context = []
    ): Response {
        $event = $this->eventFactory->createHealthCheckEvent();
        $this->eventBus->publish($event);

        return new Response(null, Response::HTTP_NO_CONTENT);
    }
}
