<?php

declare(strict_types=1);

namespace App\UserAccess\Test\Domain\OAuth;

use App\UserAccess\Domain\OAuth\AccessToken;
use App\UserAccess\Domain\OAuth\Client;
use App\UserAccess\Domain\OAuth\RefreshToken;
use App\UserAccess\Domain\OAuth\Scope;
use DateTimeImmutable;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

final class RefreshTokenTest extends TestCase
{
    public function testCreate(): void
    {
        $token = new RefreshToken();

        $client = new Client(
            identifier: 'frontend',
            name: 'Frontend',
            redirectUri: 'https://localhost:5000/ss',
        );

        $accessToken = new AccessToken(
            $client,
            [new Scope('email')]
        );
        $accessToken->setIdentifier($userIdentifier = Uuid::uuid4()->toString());
        $accessToken->setUserIdentifier($userIdentifier);

        $token->setIdentifier($identifier = Uuid::uuid4()->toString());
        $token->setExpiryDateTime($expiryDateTime = new DateTimeImmutable());
        $token->setAccessToken($accessToken);

        self::assertSame($accessToken, $token->getAccessToken());
        self::assertSame($identifier, $token->getIdentifier());
        self::assertSame($userIdentifier, $token->getUserIdentifier());
        self::assertSame($expiryDateTime, $token->getExpiryDateTime());
    }
}
