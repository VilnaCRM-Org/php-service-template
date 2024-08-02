<?php

declare(strict_types=1);

namespace App\Internal\HealthCheck\Application\EventSubscriber;

use App\Internal\HealthCheck\Domain\Event\HealthCheckEvent;
use Aws\Sqs\SqsClient;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class MessageBrokerHealthCheckSubscriber implements EventSubscriberInterface
{
    private SqsClient $sqsClient;
    private string $queueName = 'health-check-queue';

    public function __construct(SqsClient $sqsClient)
    {
        $this->sqsClient = $sqsClient;
    }

    public function onHealthCheck(HealthCheckEvent $event): void
    {
        $this->sqsClient->createQueue(['QueueName' => $this->queueName]);
    }

    public static function getSubscribedEvents(): array
    {
        return [HealthCheckEvent::class => 'onHealthCheck'];
    }
}
