<?php

declare(strict_types=1);

namespace App\Tests\Unit\Internal\HealthCheck\Application\EventSubscriber;

use App\Internal\HealthCheck\Application\EventSubscriber\MessageBrokerHealthCheckSubscriber;
use App\Internal\HealthCheck\Domain\Event\HealthCheckEvent;
use App\Tests\Unit\UnitTestCase;
use Aws\Sqs\SqsClient;
use Aws\CommandInterface;
use Aws\Exception\AwsException;

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

    public function testOnHealthCheckCreatesQueue(): void
    {
        $this->sqsClient->expects($this->once())
            ->method('__call')
            ->with($this->equalTo('createQueue'), $this->anything())
            ->willReturn(['QueueUrl' => 'http://example.com/queue/health-check-queue']);

        $event = new HealthCheckEvent();
        $this->subscriber->onHealthCheck($event);
    }

    public function testOnHealthCheckThrowsQueueAlreadyExistsException(): void
    {
        $command = $this->createMock(CommandInterface::class);

        $this->sqsClient->expects($this->once())
            ->method('__call')
            ->with($this->equalTo('createQueue'), $this->anything())
            ->willThrowException(new AwsException(
                'Queue already exists',
                $command,
                [
                    'code' => 'QueueAlreadyExists',
                ]
            ));

        $this->expectException(AwsException::class);
        $this->expectExceptionMessage('Queue already exists');
        $this->expectExceptionCode(0);

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
