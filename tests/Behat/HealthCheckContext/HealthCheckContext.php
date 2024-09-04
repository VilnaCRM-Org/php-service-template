<?php

declare(strict_types=1);

namespace App\Tests\Behat\HealthCheckContext;

use Aws\Sqs\SqsClient;
use Behat\Behat\Context\Context;
use Doctrine\Common\EventManager;
use Doctrine\DBAL\Configuration;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Driver;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\MockObject\MockObject;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Cache\Exception\CacheException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Contracts\Cache\CacheInterface;

final class HealthCheckContext extends KernelTestCase implements Context
{
    private KernelInterface $kernelInterface;
    private Response $response;

    public function __construct(
        KernelInterface $kernel
    ) {
        parent::__construct();
        $this->kernelInterface = $kernel;
    }

    /**
     * @When :method request is sent to :path
     */
    public function sendRequestTo(string $method, string $path): void
    {
        $this->response = $this->kernelInterface->handle(Request::create(
            $path,
            $method,
        ));
    }

    /**
     * @Then the response status code should be :statusCode
     */
    public function theResponseStatusCodeShouldBe(string $statusCode): void
    {
        Assert::assertEquals($statusCode, $this->response->getStatusCode());
    }

    /**
     * @Then the response body should contain :text
     */
    public function theResponseBodyShouldContain(string $text): void
    {
        $responseContent = $this->response->getContent();
        Assert::assertStringContainsString(
            $text,
            $responseContent,
            "The response body does not contain the expected text: '{$text}'."
        );
    }

    /**
     * @Given the cache is not working
     */
    public function theCacheIsNotWorking(): void
    {
        /** @var CacheInterface|MockObject $cacheMock */
        $cacheMock = $this->createMock(CacheInterface::class);

        $cacheMock->method('get')
            ->willThrowException(new CacheException('Cache is not working'));

        $container = $this->kernelInterface->getContainer();
        $container->set(CacheInterface::class, $cacheMock);
    }

    /**
     * @Given the database is not available
     */
    public function theDatabaseIsNotAvailable(): void
    {
        $driverMock = $this->createMock(Driver::class);

        $connectionMock = $this->getMockBuilder(Connection::class)
            ->setConstructorArgs([
                [],
                $driverMock,
                new Configuration(),
                new EventManager(),
            ])
            ->onlyMethods(['executeQuery'])
            ->getMock();

        $connectionMock->method('executeQuery')
            ->willThrowException(new \Exception('Database is not available'));

        $container = $this->kernelInterface
            ->getContainer()
            ->get('test.service_container');
        $container->set(Connection::class, $connectionMock);
    }

    /**
     * @Given the message broker is not available
     */
    public function theMessageBrokerIsNotAvailable(): void
    {
        $sqsClientMock = $this->createMock(SqsClient::class);

        $sqsClientMock->method('__call')
            ->willThrowException(
                new \Exception(
                    'Message broker is not available'
                )
            );

        $container = $this->kernelInterface
            ->getContainer()
            ->get('test.service_container');
        $container->set(SqsClient::class, $sqsClientMock);
    }
}
