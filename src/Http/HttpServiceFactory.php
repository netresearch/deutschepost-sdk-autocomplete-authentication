<?php

/**
 * See LICENSE.md for license details.
 */

declare(strict_types=1);

namespace PostDirekt\Sdk\Autocomplete\Authentication\Http;

use Http\Client\Common\Plugin\AuthenticationPlugin;
use Http\Client\Common\Plugin\ErrorPlugin;
use Http\Client\Common\Plugin\HeaderDefaultsPlugin;
use Http\Client\Common\Plugin\LoggerPlugin;
use Http\Client\Common\PluginClient;
use Http\Discovery\Exception\NotFoundException;
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
 * Creates preconfigured HTTP client
 *
 * @author Paul Siedler <paul.siedler@netresearch.de>
 * @author Sebastian Ertner <sebastian.ertner@netresearch.de>
 * @link https://www.netresearch.de/
 */
class HttpServiceFactory implements ServiceFactoryInterface
{
    /**
     * @var ClientInterface
     */
    private $httpClient;

    /**
     * HttpServiceFactory constructor.
     *
     * @param ClientInterface $httpClient
     */
    public function __construct(ClientInterface $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    /**
     * @param string $username
     * @param string $password
     * @param LoggerInterface $logger
     * @return AuthenticationServiceInterface
     * @throws ServiceException
     */
    public function createAuthenticationService(
        string $username,
        string $password,
        LoggerInterface $logger
    ): AuthenticationServiceInterface {
        $plugins = [
            new ErrorPlugin(),
            new AuthenticationPlugin(new BasicAuth($username, $password)),
            new LoggerPlugin($logger, new FullHttpMessageFormatter(null)),
            new HeaderDefaultsPlugin([
                'Accept' => 'application/json',
                'Charset' => 'UTF-8'
            ])
        ];
        $client = new PluginClient($this->httpClient, $plugins);

        try {
            $requestFactory = Psr17FactoryDiscovery::findRequestFactory();
        } catch (NotFoundException $exception) {
            throw new ServiceException($exception->getMessage(), $exception->getCode(), $exception);
        }

        return new AuthenticationService(
            $client,
            $requestFactory
        );
    }
}
