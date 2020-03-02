<?php

/**
 * See LICENSE.md for license details.
 */

declare(strict_types=1);

namespace PostDirekt\Sdk\Autocomplete\Authentication\Test\Expectation;

use PHPUnit\Framework\Assert;
use PHPUnit\Framework\ExpectationFailedException;
use Psr\Log\Test\TestLogger;

/**
 * Class AuthenticationService
 *
 * Provide functions for assertions management in tests
 *
 * @author Paul Siedler <paul.siedler@netresearch.de>
 * @link https://www.netresearch.de/
 */
class AuthenticationService
{
    /**
     * Assert that logger contains records with HTTP status code and messages.
     *
     * @param string $response
     * @param TestLogger $logger
     * @return void
     * @throws ExpectationFailedException
     */
    public static function assertCommunicationLogged(string $response, TestLogger $logger): void
    {
        Assert::assertTrue($logger->hasInfoRecords(), 'Logger has no info messages');

        $statusRegex = '|^HTTP/\d\.\d\s\d{3}\s[\w\s]+$|m';
        $hasStatusCode = $logger->hasInfoThatMatches($statusRegex) || $logger->hasErrorThatMatches($statusRegex);
        Assert::assertTrue($hasStatusCode, 'Logged messages do not contain status code.');

        if (!empty($response)) {
            $hasResponse = $logger->hasInfoThatContains($response) || $logger->hasErrorThatContains($response);
            Assert::assertTrue($hasResponse, 'Logged messages do not contain response');
        }
    }
}
