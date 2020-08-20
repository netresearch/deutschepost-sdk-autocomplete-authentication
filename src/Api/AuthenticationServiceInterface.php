<?php

/**
 * See LICENSE.txt for license details.
 */

declare(strict_types=1);

namespace PostDirekt\Sdk\Autocomplete\Authentication\Api;

use PostDirekt\Sdk\Autocomplete\Authentication\Api\Data\TokenInterface;
use PostDirekt\Sdk\Autocomplete\Authentication\Exception\ServiceException;

interface AuthenticationServiceInterface
{
    /**
     * Request an authentication token.
     *
     * @return TokenInterface
     * @throws ServiceException
     */
    public function authenticate(): TokenInterface;
}
