<?php

declare(strict_types=1);

namespace App\Internal\HealthCheck\Application\EventSub;

use App\Internal\HealthCheck\Domain\Event\HealthCheckEvent;
use Aws\Sqs\SqsClient;

final class BrokerCheckSubscriber extends BaseHealthCheckSubscriber
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

    private function createQueue(string $queueName): void
    {
        $this->sqsClient->createQueue(['QueueName' => $queueName]);
    }
}
