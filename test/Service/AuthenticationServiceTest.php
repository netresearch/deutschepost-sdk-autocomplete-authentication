<?php

/**
 * See LICENSE.md for license details.
 */

declare(strict_types=1);

namespace PostDirekt\Sdk\Autocomplete\Authentication\Test\Service;

use Http\Discovery\Psr17FactoryDiscovery;
use Http\Mock\Client;
use PHPUnit\Framework\TestCase;
use PostDirekt\Sdk\Autocomplete\Authentication\Exception\ServiceException;
use PostDirekt\Sdk\Autocomplete\Authentication\Http\HttpServiceFactory;
use PostDirekt\Sdk\Autocomplete\Authentication\Test\Expectation\AuthenticationService;
use Psr\Log\Test\TestLogger;

/**
 * Class AuthenticationServiceTest
 *
 * @author Max Melzer <max.melzer@netresearch.de>
 */
class AuthenticationServiceTest extends TestCase
{
    /**
     * @test
     * @throws \PostDirekt\Sdk\Autocomplete\Authentication\Exception\ServiceException
     */
    public function basicAuthenticationSucceeds()
    {
        $logger = new TestLogger();
        $httpClient = new Client();
        $responseFactory = Psr17FactoryDiscovery::findResponseFactory();
        $streamFactory = Psr17FactoryDiscovery::findStreamFactory();

        $responseData = ['access_token' => 'token', 'expires_in_epoch_seconds' => 1579179612];
        $responseBody = json_encode($responseData);
        $response = $responseFactory
            ->createResponse(200, 'OK')
            ->withBody($streamFactory->createStream($responseBody));

        $httpClient->setDefaultResponse($response);

        $serviceFactory = new HttpServiceFactory($httpClient);
        $authService = $serviceFactory->createAuthenticationService('user', 'password', $logger);

        $result = $authService->authenticate();

        $this->assertEquals($responseData['access_token'], $result->getAccessToken());
        $this->assertEquals($responseData['expires_in_epoch_seconds'], $result->getExpiresAt());

        AuthenticationService::assertCommunicationLogged($responseBody, $logger);
    }

    /**
     * @test
     * @throws ServiceException
     */
    public function basicAuthenticationFails()
    {
        $logger = new TestLogger();
        $httpClient = new Client();
        $responseFactory = Psr17FactoryDiscovery::findResponseFactory();
        $streamFactory = Psr17FactoryDiscovery::findStreamFactory();

        $responseBody = '';
        $response = $responseFactory
            ->createResponse(401, 'Unauthorized')
            ->withAddedHeader('Content-Type', 'text/plain')
            ->withBody($streamFactory->createStream($responseBody));
        $httpClient->setDefaultResponse($response);

        $serviceFactory = new HttpServiceFactory($httpClient);
        $authService = $serviceFactory->createAuthenticationService('user', 'password', $logger);
        try {
            $result = $authService->authenticate();
        } catch (ServiceException $exception) {
            AuthenticationService::assertCommunicationLogged($responseBody, $logger);
        }
    }
}
