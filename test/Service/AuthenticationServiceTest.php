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
     * @throws ServiceException
     */
    public function basicAuthenticationSucceeds()
    {
        $statusCode = 200;
        $reasonPhrase = 'OK';

        $logger = new TestLogger();
        $httpClient = new Client();
        $responseFactory = Psr17FactoryDiscovery::findResponseFactory();
        $streamFactory = Psr17FactoryDiscovery::findStreamFactory();

        $responseData = ['access_token' => 'token', 'expires_in_epoch_seconds' => 1579179612];
        $responseBody = json_encode($responseData);
        $response = $responseFactory
            ->createResponse($statusCode, $reasonPhrase)
            ->withBody($streamFactory->createStream($responseBody));

        $httpClient->setDefaultResponse($response);

        $serviceFactory = new HttpServiceFactory($httpClient);
        $authService = $serviceFactory->createAuthenticationService('user', 'password', $logger);

        $result = $authService->authenticate();

        self::assertEquals($responseData['access_token'], $result->getAccessToken());
        self::assertEquals($responseData['expires_in_epoch_seconds'], $result->getExpiresAt());

        $statusRegex = sprintf('|^HTTP/\d\.\d\s%s %s$|m', $statusCode, $reasonPhrase);
        self::assertTrue($logger->hasInfoThatMatches($statusRegex), 'Logged messages do not contain status code.');
        self::assertTrue($logger->hasInfoThatContains($responseBody), 'Logged messages do not contain response');
    }

    /**
     * @test
     * @throws ServiceException
     */
    public function basicAuthenticationFails()
    {
        $statusCode = 401;
        $reasonPhrase = 'Unauthorized';

        $this->expectException(ServiceException::class);
        $this->expectExceptionCode($statusCode);
        $this->expectExceptionMessage($reasonPhrase);

        $logger = new TestLogger();
        $httpClient = new Client();
        $responseFactory = Psr17FactoryDiscovery::findResponseFactory();

        $response = $responseFactory
            ->createResponse($statusCode, $reasonPhrase)
            ->withAddedHeader('Content-Type', 'text/plain');
        $httpClient->setDefaultResponse($response);

        $serviceFactory = new HttpServiceFactory($httpClient);
        $authService = $serviceFactory->createAuthenticationService('user', 'password', $logger);

        try {
            $authService->authenticate();
        } catch (ServiceException $exception) {
            $statusRegex = sprintf('|^HTTP/\d\.\d\s%s %s$|m', $statusCode, $reasonPhrase);
            self::assertTrue($logger->hasErrorThatMatches($statusRegex), 'Logged messages do not contain status code.');

            throw $exception;
        }
    }
}
