<?php

/**
 * See LICENSE.txt for license details.
 */

declare(strict_types=1);

namespace PostDirekt\Sdk\Autocomplete\Authentication\Model;

use PostDirekt\Sdk\Autocomplete\Authentication\Api\Data\TokenInterface;

class Token implements TokenInterface
{
    public function __construct(private readonly string $accessToken, private readonly int $expiresAt)
    {
    }

    public function getAccessToken(): string
    {
        return $this->accessToken;
    }

    public function getExpiresAt(): int
    {
        return $this->expiresAt;
    }
}
