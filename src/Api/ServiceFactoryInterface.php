<?php

/**
 * See LICENSE.md for license details.
 */

declare(strict_types=1);

namespace PostDirekt\Sdk\Autocomplete\Authentication\Api;

use PostDirekt\Sdk\Autocomplete\Authentication\Exception\ServiceException;
use Psr\Log\LoggerInterface;

/**
 * Interface AuthenticationServiceInterface
 *
 * @author Paul Siedler <paul.siedler@netresearch.de>
 * @link https://www.netresearch.de/
 */
interface ServiceFactoryInterface
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
    ): AuthenticationServiceInterface;
}
