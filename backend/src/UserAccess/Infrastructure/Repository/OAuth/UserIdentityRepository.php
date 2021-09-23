<?php

declare(strict_types=1);

namespace App\UserAccess\Infrastructure\Repository\OAuth;

use App\UserAccess\Domain\OAuth\UserIdentity;
use League\OAuth2\Server\Entities\ClientEntityInterface;
use League\OAuth2\Server\Repositories\UserRepositoryInterface;

final class UserIdentityRepository implements UserRepositoryInterface
{
    public function getUserEntityByUserCredentials(
        $username,
        $password,
        $grantType,
        ClientEntityInterface $clientEntity,
    ): ?UserIdentity {
        return null;
    }
}
