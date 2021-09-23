<?php

declare(strict_types=1);

namespace App\UserAccess\Test\Domain\OAuth;

use App\UserAccess\Domain\OAuth\AuthCode;
use App\UserAccess\Domain\OAuth\Client;
use App\UserAccess\Domain\OAuth\Scope;
use DateTimeImmutable;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

final class AuthCodeTest extends TestCase
{
    public function testCreate(): void
    {
        $code = new AuthCode();

        $code->setClient($client = new Client(
            identifier: 'frontend',
            name: 'Frontend',
            redirectUri: 'https://localhost:5000/ss',
        ),);
        $code->addScope($scope = new Scope('common'));
        $code->setIdentifier($identifier = Uuid::uuid4()->toString());
        $code->setUserIdentifier($userIdentifier = Uuid::uuid4()->toString());
        $code->setExpiryDateTime($expiryDateTime = new DateTimeImmutable());
        $code->setRedirectUri($redirectUri = 'https://localhost:5000/ss');

        self::assertSame($client, $code->getClient());
        self::assertSame([$scope], $code->getScopes());
        self::assertSame($identifier, $code->getIdentifier());
        self::assertSame($userIdentifier, $code->getUserIdentifier());
        self::assertSame($expiryDateTime, $code->getExpiryDateTime());
        self::assertSame($redirectUri, $code->getRedirectUri());
    }
}
