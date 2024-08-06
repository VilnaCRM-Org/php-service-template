<?php

declare(strict_types=1);

namespace App\Internal\HealthCheck\Application\EventSubscriber;

use App\Internal\HealthCheck\Domain\Event\HealthCheckEvent;
use Aws\Sqs\SqsClient;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

final class BrokerHealthCheckSubscriber implements EventSubscriberInterface
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

    /**
     * @return array<object, string>
     */
    public static function getSubscribedEvents(): array
    {
        return [HealthCheckEvent::class => 'onHealthCheck'];
    }
}