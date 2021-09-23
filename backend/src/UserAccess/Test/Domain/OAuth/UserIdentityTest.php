<?php

declare(strict_types=1);

namespace App\UserAccess\Test\Domain\OAuth;

use App\UserAccess\Domain\OAuth\UserIdentity;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

final class UserIdentityTest extends TestCase
{
    public function testCreate(): void
    {
        $user = new UserIdentity($identifier = Uuid::uuid4()->toString());

        self::assertSame($identifier, $user->getIdentifier());
    }
}
