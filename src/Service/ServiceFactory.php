<?php

/**
 * See LICENSE.md for license details.
 */

declare(strict_types=1);

namespace PostDirekt\Sdk\Autocomplete\Authentication\Service;

use Http\Discovery\Exception\NotFoundException;
use Http\Discovery\HttpClientDiscovery;
use PostDirekt\Sdk\Autocomplete\Authentication\Api\AuthenticationServiceInterface;
use PostDirekt\Sdk\Autocomplete\Authentication\Api\ServiceFactoryInterface;
use PostDirekt\Sdk\Autocomplete\Authentication\Exception\ServiceException;
use PostDirekt\Sdk\Autocomplete\Authentication\Http\HttpServiceFactory;
use Psr\Log\LoggerInterface;

/**
 * Class ServiceFactory
 *
 * @author Max Melzer <max.melzer@netresearch.de>
 * @link https://www.netresearch.de/
 */
class ServiceFactory implements ServiceFactoryInterface
{
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
        try {
            $httpClient = HttpClientDiscovery::find();
        } catch (NotFoundException $exception) {
            throw new ServiceException($exception->getMessage(), $exception->getCode(), $exception);
        }

        $httpServiceFactory = new HttpServiceFactory($httpClient);

        return $httpServiceFactory->createAuthenticationService($username, $password, $logger);
    }
}
