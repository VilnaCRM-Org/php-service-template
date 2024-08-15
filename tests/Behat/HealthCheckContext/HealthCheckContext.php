<?php

declare(strict_types=1);

namespace App\Tests\Behat\HealthCheckContext;

use Behat\Behat\Context\Context;
use PHPUnit\Framework\Assert;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Contracts\Cache\CacheInterface;

final class HealthCheckContext implements Context
{
    private KernelInterface $kernel;
    private Response $response;

    public function __construct(
        KernelInterface $kernel
    ) {
        $this->kernel = $kernel;
    }

    /**
     * @When :method request is send to :path
     */
    public function requestSendTo(string $method, string $path): void
    {
        $this->response = $this->kernel->handle(Request::create(
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
     * @Given the cache is not working
     */
    public function theCacheIsNotWorking(): void
    {
        $container = $this->kernel->getContainer();

        $cacheTestDouble = new class() implements CacheInterface {
            public function get(
                string $key,
                callable $callback,
                ?float $beta = null,
                ?array &$metadata = null
            ): mixed {
                throw new \Exception('Cache error');
            }

            public function delete(string $key): bool
            {
                return true;
            }
        };

        $container->set(CacheInterface::class, $cacheTestDouble);
    }
}
