<?php

declare(strict_types=1);

namespace App\Eternal\HealthCheck\Application\Processor;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Eternal\HealthCheck\Application\HealthCheckCommandFactoryInterface;
use App\Shared\Domain\Bus\Command\CommandBusInterface;
use Symfony\Component\HttpFoundation\Response;

/**
 * @implements ProcessorInterface<mixed, Response>
 */
final class HealthCheckProcessor implements ProcessorInterface
{
    public function __construct(
        private CommandBusInterface $commandBus,
        private HealthCheckCommandFactoryInterface $healthCheckCommandFactory
    ) {
    }

    /**
     * @param mixed $data
     * @param Operation $operation
     * @param array<string, string> $uriVariables
     * @param array<string, mixed> $context
     * @return Response
     */
    public function process(
        mixed $data,
        Operation $operation,
        array $uriVariables = [],
        array $context = []
    ): Response {
        $command = $this->healthCheckCommandFactory->create();
        $this->commandBus->dispatch($command);

        return new Response(
            content: json_encode(['status' => 'ok']),
            status: Response::HTTP_OK,
            headers: ['Content-Type' => 'application/json']
        );
    }
}
