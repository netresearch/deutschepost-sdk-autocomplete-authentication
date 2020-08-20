<?php

/**
 * See LICENSE.txt for license details.
 */

declare(strict_types=1);

namespace PostDirekt\Sdk\Autocomplete\Authentication\Http;

use Http\Client\Common\Plugin\AuthenticationPlugin;
use Http\Client\Common\Plugin\ErrorPlugin;
use Http\Client\Common\Plugin\HeaderDefaultsPlugin;
use Http\Client\Common\Plugin\LoggerPlugin;
use Http\Client\Common\PluginClient;
use Http\Discovery\Psr17FactoryDiscovery;
use Http\Message\Authentication\BasicAuth;
use Http\Message\Formatter\FullHttpMessageFormatter;
use PostDirekt\Sdk\Autocomplete\Authentication\Api\AuthenticationServiceInterface;
use PostDirekt\Sdk\Autocomplete\Authentication\Api\ServiceFactoryInterface;
use PostDirekt\Sdk\Autocomplete\Authentication\Exception\ServiceException;
use PostDirekt\Sdk\Autocomplete\Authentication\Service\AuthenticationService;
use Psr\Http\Client\ClientInterface;
use Psr\Log\LoggerInterface;

/**
 * Class HttpServiceFactory
 *
 * Creates service instance with given HTTP client and default plugins.
 */
class HttpServiceFactory implements ServiceFactoryInterface
{
    /**
     * @var ClientInterface
     */
    private $httpClient;

    public function __construct(ClientInterface $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    public function createAuthenticationService(
        string $username,
        string $password,
        LoggerInterface $logger
    ): AuthenticationServiceInterface {
        $plugins = [
            new AuthenticationPlugin(new BasicAuth($username, $password)),
            new LoggerPlugin($logger, new FullHttpMessageFormatter(null)),
            new ErrorPlugin(),
            new HeaderDefaultsPlugin([
                'Accept' => 'application/json',
                'Charset' => 'UTF-8',
            ])
        ];

        try {
            $client = new PluginClient($this->httpClient, $plugins);
            $requestFactory = Psr17FactoryDiscovery::findRequestFactory();

            return new AuthenticationService($client, $requestFactory);
        } catch (\Exception $exception) {
            throw new ServiceException($exception->getMessage(), $exception->getCode(), $exception);
        }
    }
}
