<?php

declare(strict_types=1);

namespace App\UserAccess\Infrastructure\Repository\OAuth;

use App\UserAccess\Domain\OAuth\Scope;
use League\OAuth2\Server\Entities\ClientEntityInterface;
use League\OAuth2\Server\Repositories\ScopeRepositoryInterface;

final class ScopeRepository implements ScopeRepositoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function getScopeEntityByIdentifier($identifier): ?Scope
    {
        $scopes = [
            'basic' => [
                'description' => 'Basic details about you',
            ],
            'email' => [
                'description' => 'Your email address',
            ],
        ];

        if (array_key_exists($identifier, $scopes) === false) {
            return null;
        }

        $scope = new Scope($identifier);

        return $scope;
    }

    /**
     * {@inheritdoc}
     */
    public function finalizeScopes(
        array $scopes,
        $grantType,
        ClientEntityInterface $clientEntity,
        $userIdentifier = null
    ): array {
        return $scopes;
    }
}
