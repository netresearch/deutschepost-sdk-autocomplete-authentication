<?php

/**
 * See LICENSE.txt for license details.
 */

declare(strict_types=1);

namespace PostDirekt\Sdk\Autocomplete\Service;

use Http\Discovery\Psr17FactoryDiscovery;
use Http\Mock\Client;
use PHPUnit\Framework\TestCase;
use PostDirekt\Sdk\Autocomplete\Authentication\Exception\ServiceException;
use PostDirekt\Sdk\Autocomplete\Authentication\Http\HttpServiceFactory;
use Psr\Log\Test\TestLogger;

class AuthenticationServiceTest extends TestCase
{
    /**
     * @throws ServiceException
     */
    #[\PHPUnit\Framework\Attributes\Test]
    public function basicAuthenticationSucceeds(): void
    {
        $statusCode = 200;
        $reasonPhrase = 'OK';

        $logger = new TestLogger();
        $httpClient = new Client();
        $responseFactory = Psr17FactoryDiscovery::findResponseFactory();
        $streamFactory = Psr17FactoryDiscovery::findStreamFactory();

        $responseData = ['access_token' => 'token', 'expires_in_epoch_seconds' => 1_579_179_612];
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
     * @throws ServiceException
     */
    #[\PHPUnit\Framework\Attributes\Test]
    public function basicAuthenticationFails(): void
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
