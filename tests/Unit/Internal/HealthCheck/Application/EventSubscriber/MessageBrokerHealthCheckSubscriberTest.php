<?php

declare(strict_types=1);

namespace App\Tests\Unit\Internal\HealthCheck\Application\EventSubscriber;

use App\Internal\HealthCheck\Application\EventSubscriber\MessageBrokerHealthCheckSubscriber;
use App\Internal\HealthCheck\Domain\Event\HealthCheckEvent;
use App\Tests\Unit\UnitTestCase;
use Aws\Sqs\SqsClient;

final class MessageBrokerHealthCheckSubscriberTest extends UnitTestCase
{
    private SqsClient $sqsClient;
    private MessageBrokerHealthCheckSubscriber $subscriber;

    protected function setUp(): void
    {
        parent::setUp();

        $this->sqsClient = $this->createMock(SqsClient::class);
        $this->subscriber = new MessageBrokerHealthCheckSubscriber($this->sqsClient);
    }

    public function testOnHealthCheck(): void
    {
        $this->sqsClient->expects($this->once())
            ->method('__call')
            ->with($this->equalTo('listQueues'), $this->anything())
            ->willReturn(['QueueUrls' => []]);

        $event = new HealthCheckEvent();
        $this->subscriber->onHealthCheck($event);
    }

    public function testGetSubscribedEvents(): void
    {
        $this->assertSame(
            [HealthCheckEvent::class => 'onHealthCheck'],
            MessageBrokerHealthCheckSubscriber::getSubscribedEvents()
        );
    }
}
