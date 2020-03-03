<?php

/**
 * See LICENSE.md for license details.
 */

declare(strict_types=1);

namespace PostDirekt\Sdk\Autocomplete\Authentication\Api\Data;

/**
 * Interface TokenInterface
 *
 * @author Paul Siedler <paul.siedler@netresearch.de>
 * @link https://www.netresearch.de/
 */
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
