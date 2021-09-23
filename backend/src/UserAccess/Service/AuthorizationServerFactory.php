<?php

declare(strict_types=1);

namespace App\UserAccess\Service;

use App\SharedKernel\Domain\Settings\Settings;
use DateInterval;
use League\OAuth2\Server\AuthorizationServer;
use League\OAuth2\Server\CryptKey;
use League\OAuth2\Server\Grant\AuthCodeGrant;
use League\OAuth2\Server\Grant\RefreshTokenGrant;
use League\OAuth2\Server\Repositories\AccessTokenRepositoryInterface;
use League\OAuth2\Server\Repositories\AuthCodeRepositoryInterface;
use League\OAuth2\Server\Repositories\ClientRepositoryInterface;
use League\OAuth2\Server\Repositories\RefreshTokenRepositoryInterface;
use League\OAuth2\Server\Repositories\ScopeRepositoryInterface;

final class AuthorizationServerFactory
{
    public static function create(
        ClientRepositoryInterface $clientRepository,
        AccessTokenRepositoryInterface $accessTokenRepository,
        ScopeRepositoryInterface $scopeRepository,
        AuthCodeRepositoryInterface $authCodeRepository,
        RefreshTokenRepositoryInterface $refreshTokenRepository,
        Settings $setting,
        string $privateKey,
        string $encryptionKey,
    ): AuthorizationServer
    {
        $server = new AuthorizationServer(
            $clientRepository,
            $accessTokenRepository,
            $scopeRepository,
            new CryptKey($privateKey, null, false),
            $encryptionKey
        );

        $grant = new AuthCodeGrant(
            $authCodeRepository,
            $refreshTokenRepository,
            new DateInterval($setting->getAuthCodeInterval()),
        );

        $grant->setRefreshTokenTTL(new DateInterval($setting->getRefreshTokenInterval()));
        $server->enableGrantType($grant, new DateInterval($setting->getAccessTokenInterval()));

        $grant = new RefreshTokenGrant($refreshTokenRepository);
        $grant->setRefreshTokenTTL(new DateInterval($setting->getRefreshTokenInterval()));
        $server->enableGrantType($grant, new DateInterval($setting->getAccessTokenInterval()));

        return $server;
    }
}
