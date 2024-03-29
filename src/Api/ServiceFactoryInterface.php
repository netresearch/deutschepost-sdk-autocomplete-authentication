<?php

/**
 * See LICENSE.txt for license details.
 */

declare(strict_types=1);

namespace PostDirekt\Sdk\Autocomplete\Authentication\Api;

use PostDirekt\Sdk\Autocomplete\Authentication\Exception\ServiceException;
use Psr\Log\LoggerInterface;

interface ServiceFactoryInterface
{
    /**
     * @throws ServiceException
     */
    public function createAuthenticationService(
        string $username,
        string $password,
        LoggerInterface $logger
    ): AuthenticationServiceInterface;
}
