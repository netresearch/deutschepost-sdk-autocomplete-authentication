<?php

/**
 * See LICENSE.md for license details.
 */

declare(strict_types=1);

namespace PostDirekt\Sdk\Autocomplete\Authentication\Service;

use PostDirekt\Sdk\Autocomplete\Authentication\Api\AuthenticationServiceInterface;
use PostDirekt\Sdk\Autocomplete\Authentication\Api\Data\TokenInterface;
use PostDirekt\Sdk\Autocomplete\Authentication\Exception\ServiceException;
use PostDirekt\Sdk\Autocomplete\Authentication\Model\Token;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;

/**
 * Class AuthenticationService
 *
 * @author Paul Siedler <paul.siedler@netresearch.de>
 * @link https://www.netresearch.de/
 */
class AuthenticationService implements AuthenticationServiceInterface
{
    private const URL = 'https://autocomplete2.postdirekt.de/autocomplete2/token';

    /**
     * @var ClientInterface
     */
    private $client;

    /**
     * @var RequestFactoryInterface
     */
    private $requestFactory;

    /**
     * AuthenticationService constructor.
     *
     * @param ClientInterface $client
     * @param RequestFactoryInterface $requestFactory
     */
    public function __construct(ClientInterface $client, RequestFactoryInterface $requestFactory)
    {
        $this->client = $client;
        $this->requestFactory = $requestFactory;
    }

    /**
     * @return TokenInterface
     * @throws ServiceException
     */
    public function authenticate(): TokenInterface
    {
        try {
            $httpRequest = $this->requestFactory->createRequest('GET', self::URL);
            $response = $this->client->sendRequest($httpRequest);
            $responseData = json_decode((string) $response->getBody(), true);
            $token = new Token(
                $responseData['access_token'],
                $responseData['expires_in_epoch_seconds']
            );
        } catch (\Throwable $exception) {
            throw new ServiceException($exception->getMessage(), $exception->getCode(), $exception);
        }

        return $token;
    }
}
