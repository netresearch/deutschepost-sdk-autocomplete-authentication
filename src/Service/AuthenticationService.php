<?php

/**
 * See LICENSE.txt for license details.
 */

declare(strict_types=1);

namespace PostDirekt\Sdk\Autocomplete\Authentication\Service;

use PostDirekt\Sdk\Autocomplete\Authentication\Api\AuthenticationServiceInterface;
use PostDirekt\Sdk\Autocomplete\Authentication\Api\Data\TokenInterface;
use PostDirekt\Sdk\Autocomplete\Authentication\Exception\ServiceException;
use PostDirekt\Sdk\Autocomplete\Authentication\Model\Token;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;

class AuthenticationService implements AuthenticationServiceInterface
{
    private const URL = 'https://autocomplete2.postdirekt.de/autocomplete2/token';

    public function __construct(
        private readonly ClientInterface $client,
        private readonly RequestFactoryInterface $requestFactory
    ) {
    }

    public function authenticate(): TokenInterface
    {
        try {
            $httpRequest = $this->requestFactory->createRequest('GET', self::URL);
            $response = $this->client->sendRequest($httpRequest);
            $responseData = json_decode((string) $response->getBody(), true, 512, JSON_THROW_ON_ERROR);

            return new Token($responseData['access_token'], $responseData['expires_in_epoch_seconds']);
        } catch (\Throwable $exception) {
            throw new ServiceException($exception->getMessage(), $exception->getCode(), $exception);
        }
    }
}
