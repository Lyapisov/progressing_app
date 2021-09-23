<?php

declare(strict_types=1);

namespace App\UserAccess\Test\Helper;

use App\UserAccess\Domain\OAuth\AccessToken;
use App\UserAccess\Domain\OAuth\Client;
use App\UserAccess\Domain\OAuth\Scope;
use DateTimeImmutable;
use League\OAuth2\Server\CryptKey;

final class AuthHeader
{
    public static function for(string $userId): string
    {
        $token = new AccessToken(
            new Client(
                identifier: 'frontend',
                name: 'Schedule',
                redirectUri: 'https://localhost:5000/ss'
            ),
            [new Scope('common')],
        );

        $token->setIdentifier(bin2hex(random_bytes(40)));
        $token->setExpiryDateTime(new DateTimeImmutable('+1000 years'));
        $token->setUserIdentifier($userId);
        $token->setPrivateKey(new CryptKey(getenv('JWT_PRIVATE_KEY_PATH'), null, false));

        return 'Bearer ' . $token;
    }
}
