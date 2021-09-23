<?php

declare(strict_types=1);

namespace App\SharedKernel\Domain\Assert;

use DomainException;

final class Assert extends \Webmozart\Assert\Assert
{
    /**
     * @param array<string> $haystack
     */
    public static function assertStringInArray(
        string $needle,
        array $haystack,
        string $message
    ): void {
        if (!in_array($needle, $haystack)) {
            Assert::reportInvalidArgument($message);
        }
    }

    public static function reportInvalidArgument($message): void
    {
        throw new DomainException($message);
    }
}
