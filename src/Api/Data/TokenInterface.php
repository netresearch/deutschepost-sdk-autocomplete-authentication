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
     *
     * @return string
     */
    public function getAccessToken(): string;

    /**
     * The token expiry timestamp (unix/epoch time), in seconds.
     *
     * @return int
     */
    public function getExpiresAt(): int;
}
