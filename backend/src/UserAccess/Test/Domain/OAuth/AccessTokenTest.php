<?php

declare(strict_types=1);

namespace App\UserAccess\Test\Domain\OAuth;

use App\UserAccess\Domain\OAuth\AccessToken;
use App\UserAccess\Domain\OAuth\Client;
use App\UserAccess\Domain\OAuth\Scope;
use DateTimeImmutable;
use League\OAuth2\Server\CryptKey;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

final class AccessTokenTest extends TestCase
{
    public function testCreate(): void
    {
        $token = new AccessToken(
            $client = new Client(
                identifier: 'frontend',
                name: 'Frontend',
                redirectUri: 'https://localhost:5000/ss',
            ),
            $scopes = [new Scope('common')]
        );

        $token->setIdentifier($identifier = Uuid::uuid4()->toString());
        $token->setUserIdentifier($userIdentifier = Uuid::uuid4()->toString());
        $token->setExpiryDateTime($expiryDateTime = new DateTimeImmutable());

        $token->setPrivateKey(new CryptKey(getenv('JWT_PRIVATE_KEY_PATH'), null, false));
        $jwt = $token->convertToJWT();

        self::assertSame($client, $token->getClient());
        self::assertSame($scopes, $token->getScopes());
        self::assertSame($identifier, $token->getIdentifier());
        self::assertSame($userIdentifier, $token->getUserIdentifier());
        self::assertSame($expiryDateTime, $token->getExpiryDateTime());
        self::assertSame($userIdentifier, $jwt->claims()->get('sub'));
    }
}
