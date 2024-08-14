<?php

declare(strict_types=1);

namespace App\Tests\Integration\Internal\HealthCheck\Application\EventSub;

use App\Internal\HealthCheck\Application\EventSub\BrokerCheckSubscriber;
use App\Internal\HealthCheck\Domain\Event\HealthCheckEvent;
use App\Tests\Integration\IntegrationTestCase;
use Aws\Sqs\SqsClient;
use PHPUnit\Framework\MockObject\MockObject;

final class BrokerCheckSubscriberTest extends IntegrationTestCase
{
    private MockObject $sqsClient;
    private BrokerCheckSubscriber $subscriber;
    private string $testQueueName = 'test-queue';

    protected function setUp(): void
    {
        parent::setUp();

        $this->sqsClient = $this->createMock(SqsClient::class);

        $this->subscriber = new BrokerCheckSubscriber(
            $this->sqsClient,
            $this->testQueueName
        );
    }

    public function testOnHealthCheck(): void
    {
        $this->sqsClient->expects($this->once())
            ->method('createQueue')
            ->with(['QueueName' => $this->testQueueName]);

        $event = $this->createMock(HealthCheckEvent::class);
        $this->subscriber->onHealthCheck($event);
    }

    public function testGetSubscribedEvents(): void
    {
        $this->assertSame(
            [HealthCheckEvent::class => 'onHealthCheck'],
            BrokerCheckSubscriber::getSubscribedEvents()
        );
    }
}
