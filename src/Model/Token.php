<?php

/**
 * See LICENSE.md for license details.
 */

declare(strict_types=1);

namespace PostDirekt\Sdk\Autocomplete\Authentication\Model;

use PostDirekt\Sdk\Autocomplete\Authentication\Api\Data\TokenInterface;

/**
 * Class Token
 *
 * @author Paul Siedler <paul.siedler@netresearch.de>
 * @link https://www.netresearch.de/
 */
class Token implements TokenInterface
{
    /**
     * @var string
     */
    private $accessToken;

    /**
     * @var int
     */
    private $expiresAt;

    /**
     * Token constructor.
     *
     * @param string $accessToken
     * @param int $expiresAt
     */
    public function __construct(string $accessToken, int $expiresAt)
    {
        $this->accessToken = $accessToken;
        $this->expiresAt = $expiresAt;
    }

    /**
     * @return string
     */
    public function getAccessToken(): string
    {
        return $this->accessToken;
    }

    /**
     * @return int
     */
    public function getExpiresAt(): int
    {
        return $this->expiresAt;
    }
}
