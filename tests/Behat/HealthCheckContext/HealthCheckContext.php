<?php

namespace App\Tests\Behat\HealthCheckContext;

use Behat\Behat\Context\Context;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\KernelInterface;

class HealthCheckContext implements Context
{
    private KernelInterface $kernel;
    private Response $response;

    public function __construct(
        KernelInterface $kernel
    )
    {
        $this->kernel = $kernel;
    }

    /**
     * @Given the system is running
     */
    public function theSystemIsRunning()
    {
        // Assume the system is set to an operational state.
    }

    /**
     * @When GET request is send to :url
     */
    public function getRequestIsSendTo($url)
    {
        // Create a request and handle it using the Symfony kernel.
        $request = Request::create($url, 'GET');
        $this->response = $this->kernel->handle($request);
    }

    /**
     * @Then the response status code should be :statusCode
     */
    public function theResponseStatusCodeShouldBe($statusCode)
    {
        // Check the response status code.
        if ($this->response->getStatusCode() !== (int)$statusCode) {
            throw new \Exception('Expected status code ' . $statusCode . ' but got ' . $this->response->getStatusCode());
        }
    }
}
