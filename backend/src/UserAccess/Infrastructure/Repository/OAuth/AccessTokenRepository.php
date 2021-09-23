<?php

declare(strict_types=1);

namespace App\UserAccess\Infrastructure\Repository\OAuth;

use App\UserAccess\Domain\OAuth\AccessToken;
use League\OAuth2\Server\Entities\AccessTokenEntityInterface;
use League\OAuth2\Server\Entities\ClientEntityInterface;
use League\OAuth2\Server\Repositories\AccessTokenRepositoryInterface;

final class AccessTokenRepository implements AccessTokenRepositoryInterface
{

    public function getNewToken(
        ClientEntityInterface $clientEntity,
        array $scopes,
        $userIdentifier = null
    ): AccessToken
    {
        $accessToken = new AccessToken($clientEntity, $scopes);

        if ($userIdentifier !== null) {
            $accessToken->setUserIdentifier((string) $userIdentifier);
        }

        return $accessToken;
    }

    public function persistNewAccessToken(AccessTokenEntityInterface $accessTokenEntity): void
    {
        // TODO: Implement persistNewAccessToken() method.
    }

    public function revokeAccessToken($tokenId): void
    {
        // TODO: Implement revokeAccessToken() method.
    }

    public function isAccessTokenRevoked($tokenId): bool
    {

        return false;
    }
}
