<?php

namespace App\Internal\HealthCheck\Application\EventSubscriber;

use App\Internal\HealthCheck\Domain\Event\HealthCheckEvent;
use App\Shared\Domain\Bus\Event\DomainEventSubscriberInterface;
use Aws\Sqs\SqsClient;
use Aws\Exception\AwsException;

final class MessageBrokerHealthCheckSubscriber implements DomainEventSubscriberInterface
{
    private SqsClient $sqsClient;

    public function __construct(SqsClient $sqsClient)
    {
        $this->sqsClient = $sqsClient;
    }

    /**
     * @throws AwsException
     */
    public function __invoke(HealthCheckEvent $event): void
    {
        $this->sqsClient->listQueues();
    }

    public function subscribedTo(): array
    {
        return [HealthCheckEvent::class];
    }
}
