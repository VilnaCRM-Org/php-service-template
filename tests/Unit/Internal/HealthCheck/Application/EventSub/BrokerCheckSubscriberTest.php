<?php

declare(strict_types=1);

namespace App\Tests\Unit\Internal\HealthCheck\Application\EventSub;

use App\Internal\HealthCheck\Application\EventSub\BrokerCheckSubscriber;
use App\Internal\HealthCheck\Domain\Event\HealthCheckEvent;
use App\Tests\Unit\UnitTestCase;
use Aws\CommandInterface;
use Aws\Exception\AwsException;
use Aws\Result;
use Aws\Sqs\SqsClient;
use PHPUnit\Framework\MockObject\MockObject;

final class BrokerCheckSubscriberTest extends UnitTestCase
{
    private SqsClient|MockObject $sqsClient;
    private BrokerCheckSubscriber $subscriber;

    protected function setUp(): void
    {
        parent::setUp();

        $this->sqsClient = $this->createMock(SqsClient::class);
        $this->subscriber = new BrokerCheckSubscriber($this->sqsClient);
    }

    public function testOnHealthCheckCreatesQueue(): void
    {
        $result = new Result(
            ['QueueUrl' => 'http://example.com/queue/health-check-queue']
        );

        $this->sqsClient->expects($this->once())
            ->method('__call')
            ->with($this->equalTo(
                'createQueue'
            ), $this->equalTo([['QueueName' => 'health-check-queue']]))
            ->willReturn($result);

        $event = new HealthCheckEvent();
        $this->subscriber->onHealthCheck($event);
    }

    public function testOnHealthCheckHandlesQueueAlreadyExistsException(): void
    {
        $command = $this->createMock(CommandInterface::class);

        $this->sqsClient->expects($this->once())
            ->method('__call')
            ->with($this->equalTo(
                'createQueue'
            ), $this->equalTo([['QueueName' => 'health-check-queue']]))
            ->willThrowException(new AwsException(
                'Queue already exists',
                $command,
                [
                    'code' => 'QueueAlreadyExists',
                ]
            ));

        try {
            $event = new HealthCheckEvent();
            $this->subscriber->onHealthCheck($event);
        } catch (AwsException $e) {
            $this->assertEquals('Queue already exists', $e->getMessage());
            $this->assertEquals('QueueAlreadyExists', $e->getAwsErrorCode());
        }
    }

    public function testGetSubscribedEvents(): void
    {
        $this->assertSame(
            [HealthCheckEvent::class => 'onHealthCheck'],
            BrokerCheckSubscriber::getSubscribedEvents()
        );
    }
}
