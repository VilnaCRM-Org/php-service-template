<?php

declare(strict_types=1);

namespace App\Tests\Behat\HealthCheckContext;

use Behat\Behat\Context\Context;
use PHPUnit\Framework\Assert;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\KernelInterface;

class HealthCheckContext implements Context
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
    public function requestSendTo(string $method, string $path)
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
}
