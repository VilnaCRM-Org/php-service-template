<?php

declare(strict_types=1);

namespace App\Tests\Behat;

use Behat\Behat\Context\Context;
use Behat\Behat\Hook\Scope\BeforeScenarioScope;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\KernelInterface;
use TwentytwoLabs\BehatOpenApiExtension\Context\RestContext;

final class DemoContext implements Context
{
    private RestContext $restContext;

    public function __construct(
        private readonly KernelInterface $kernel,
        private ?Response $response
    ) {
    }

    /**
     * @BeforeScenario
     */
    public function gatherContexts(BeforeScenarioScope $scope): void
    {
        $environment = $scope->getEnvironment();
        $this->restContext = $environment->getContext(RestContext::class);
    }

    /**
     * @When a demo scenario sends a request to :path
     */
    public function aDemoScenarioSendsARequestTo(string $path): void
    {
        $this->restContext->iSendARequestTo('GET', $path);
    }

    /**
     * @Then the response should be received
     */
    public function theResponseShouldBeReceived(): void
    {
        if (
            $this->restContext
                ->getSession()
                ->getPage()
                ->getContent() === null
        ) {
            throw new \RuntimeException('No response received');
        }

        if (
            $this->restContext->getSession()->getStatusCode()
            !== Response::HTTP_OK
        ) {
            throw new \RuntimeException('Response status code is not 200');
        }
    }
}
