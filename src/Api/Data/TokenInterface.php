<?php

/**
 * See LICENSE.txt for license details.
 */

declare(strict_types=1);

namespace PostDirekt\Sdk\Autocomplete\Authentication\Api\Data;

interface TokenInterface
{
    /**
     * The access token itself
     */
    public function getAccessToken(): string;

    /**
     * The token expiry timestamp (unix/epoch time), in seconds.
     */
    public function getExpiresAt(): int;
}
