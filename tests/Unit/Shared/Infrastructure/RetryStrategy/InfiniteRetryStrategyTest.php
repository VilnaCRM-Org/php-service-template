<?php

declare(strict_types=1);

namespace App\Tests\Unit\Shared\Infrastructure\RetryStrategy;

use App\Shared\Infrastructure\RetryStrategy\InfiniteRetryStrategy;
use App\Tests\Unit\UnitTestCase;
use Symfony\Component\HttpClient\Response\AsyncContext;
use Symfony\Component\Messenger\Envelope;

final class InfiniteRetryStrategyTest extends UnitTestCase
{
    private InfiniteRetryStrategy $retryStrategy;

    protected function setUp(): void
    {
        parent::setUp();

        $this->retryStrategy = new InfiniteRetryStrategy();
    }

    public function testShouldRetry(): void
    {
        $context = $this->createMock(AsyncContext::class);

        $responseContent = null;
        $exception = null;

        $this->assertTrue(
            $this->retryStrategy->shouldRetry(
                $context,
                $responseContent,
                $exception
            )
        );
    }

    public function testGetDelay(): void
    {
        $context = $this->createMock(AsyncContext::class);

        $responseContent = null;
        $exception = null;

        $this->assertSame(
            60000,
            $this->retryStrategy->getDelay(
                $context,
                $responseContent,
                $exception
            )
        );
    }

    public function testIsRetryable(): void
    {
        $message = $this->createMock(Envelope::class);

        $this->assertTrue($this->retryStrategy->isRetryable($message));
    }

    public function testGetWaitingTime(): void
    {
        $message = $this->createMock(Envelope::class);

        $this->assertSame(
            60000,
            $this->retryStrategy->getWaitingTime($message)
        );
    }
}
