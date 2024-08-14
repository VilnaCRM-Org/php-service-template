<?php

declare(strict_types=1);

namespace App\Tests\Integration\Internal\HealthCheck\Application\EventSub;

use App\Internal\HealthCheck\Application\EventSub\BrokerCheckSubscriber;
use App\Internal\HealthCheck\Domain\Event\HealthCheckEvent;
use App\Tests\Integration\IntegrationTestCase;
use Aws\Sqs\SqsClient;

final class BrokerCheckSubscriberTest extends IntegrationTestCase
{
    private SqsClient $sqsClient;
    private string $testQueueName = 'test-queue';
    private BrokerCheckSubscriber $subscriber;

    protected function setUp(): void
    {
        parent::setUp();
        $this->sqsClient = $this->container->get(SqsClient::class);
        $this->subscriber = new BrokerCheckSubscriber($this->sqsClient);
    }

    public function testOnHealthCheck(): void
    {
        $this->sqsClient->createQueue(['QueueName' => $this->testQueueName]);

        $result = $this->sqsClient->getQueueUrl(
            ['QueueName' => $this->testQueueName]
        );
        $this->subscriber->onHealthCheck(new HealthCheckEvent());
        $queueUrl = $result->get('QueueUrl');
        $this->assertIsString($queueUrl, 'Queue URL should be a string');
        $this->assertNotEmpty($queueUrl, 'Queue URL should not be empty');
    }

    public function testGetSubscribedEvents(): void
    {
        $this->assertSame(
            [HealthCheckEvent::class => 'onHealthCheck'],
            BrokerCheckSubscriber::getSubscribedEvents()
        );
    }
}
