<?php

/**
 * See LICENSE.md for license details.
 */

declare(strict_types=1);

namespace PostDirekt\Sdk\Autocomplete\Authentication\Api;

use PostDirekt\Sdk\Autocomplete\Authentication\Api\Data\TokenInterface;
use PostDirekt\Sdk\Autocomplete\Authentication\Exception\ServiceException;

/**
 * Interface AuthenticationServiceInterface
 *
 * @author Paul Siedler <paul.siedler@netresearch.de>
 * @link https://www.netresearch.de/
 */
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
