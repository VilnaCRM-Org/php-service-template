<?php

declare(strict_types=1);

namespace App\Internal\HealthCheck\Application\EventSubscriber;

use App\Internal\HealthCheck\Domain\Event\HealthCheckEvent;
use Aws\Sqs\SqsClient;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

final class BrokerHealthCheckSubscriber implements EventSubscriberInterface
{
    private SqsClient $sqsClient;
    private string $queueName;

    public function __construct(
        SqsClient $sqsClient,
        string $queueName = 'health-check-queue'
    ) {
        $this->sqsClient = $sqsClient;
        $this->queueName = $queueName;
    }

    public function onHealthCheck(HealthCheckEvent $event): void
    {
        $this->createQueue($this->queueName);
    }

    /**
     * @return array<class-string, string>
     */
    public static function getSubscribedEvents(): array
    {
        return [HealthCheckEvent::class => 'onHealthCheck'];
    }

    private function createQueue(string $queueName): void
    {
        $this->sqsClient->createQueue(['QueueName' => $queueName]);
    }
}
