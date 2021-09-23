<?php

declare(strict_types=1);

namespace App\UserAccess\Test\Domain\OAuth;

use App\UserAccess\Domain\OAuth\Scope;
use PHPUnit\Framework\TestCase;

final class ScopeTest extends TestCase
{
    public function testCreate(): void
    {
        $scope = new Scope($identifier = 'common');

        self::assertSame($identifier, $scope->getIdentifier());
        self::assertSame($identifier, $scope->jsonSerialize());
    }
}
