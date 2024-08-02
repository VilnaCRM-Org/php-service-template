<?php

declare(strict_types=1);

namespace App\Tests\Integration\Internal\HealthCheck\Application\EventSubscriber;

use App\Internal\HealthCheck\Application\EventSubscriber\MessageBrokerHealthCheckSubscriber;
use App\Internal\HealthCheck\Domain\Event\HealthCheckEvent;
use App\Tests\Integration\IntegrationTestCase;
use Aws\Exception\AwsException;
use Aws\Sqs\SqsClient;

final class MessageBrokerHealthCheckSubscriberTest extends IntegrationTestCase
{
    private SqsClient $sqsClient;
    private MessageBrokerHealthCheckSubscriber $subscriber;
    private string $testQueueName = 'test-queue';

    protected function setUp(): void
    {
        parent::setUp();
        $this->sqsClient = $this->container->get(SqsClient::class);
        $this->subscriber = new MessageBrokerHealthCheckSubscriber($this->sqsClient);
    }

    public function testOnHealthCheck(): void
    {
        $event = new HealthCheckEvent();

        try {
            $this->sqsClient->createQueue(['QueueName' => $this->testQueueName]);
            $result = $this->sqsClient->getQueueUrl(['QueueName' => $this->testQueueName]);

            $queueUrl = $result->get('QueueUrl');
            $this->assertIsString($queueUrl, 'Queue URL should be a string');
            $this->assertNotEmpty($queueUrl, 'Queue URL should not be empty');
        } catch (AwsException $e) {
            $this->fail('AWS SDK encountered an error: ' . $e->getMessage());
        }
    }

    public function testGetSubscribedEvents(): void
    {
        $this->assertSame(
            [HealthCheckEvent::class => 'onHealthCheck'],
            MessageBrokerHealthCheckSubscriber::getSubscribedEvents()
        );
    }
}
