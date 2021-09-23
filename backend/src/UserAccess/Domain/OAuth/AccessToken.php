<?php

declare(strict_types=1);

namespace App\UserAccess\Domain\OAuth;

use DateTimeImmutable;
use Lcobucci\JWT\Token\Plain;
use League\OAuth2\Server\Entities\AccessTokenEntityInterface;
use League\OAuth2\Server\Entities\ClientEntityInterface;
use League\OAuth2\Server\Entities\ScopeEntityInterface;
use League\OAuth2\Server\Entities\Traits\AccessTokenTrait;
use League\OAuth2\Server\Entities\Traits\EntityTrait;
use League\OAuth2\Server\Entities\Traits\TokenEntityTrait;

final class AccessToken implements AccessTokenEntityInterface
{
    use AccessTokenTrait;
    use EntityTrait;
    use TokenEntityTrait;

    /**
     * @param ClientEntityInterface $client
     * @param ScopeEntityInterface[] $scopes
     */
    public function __construct(ClientEntityInterface $client, array $scopes)
    {
        $this->setClient($client);

        foreach ($scopes as $scope) {
            $this->addScope($scope);
        }
    }

    public function convertToJWT(): Plain
    {
        $this->initJwtConfiguration();

        return $this->jwtConfiguration->builder()
            ->permittedFor($this->getClient()->getIdentifier())
            ->identifiedBy((string) $this->getIdentifier())
            ->issuedAt(new DateTimeImmutable())
            ->canOnlyBeUsedAfter(new DateTimeImmutable())
            ->expiresAt($this->getExpiryDateTime())
            ->relatedTo((string)$this->getUserIdentifier())
            ->withClaim('scopes', $this->getScopes())
            ->getToken($this->jwtConfiguration->signer(), $this->jwtConfiguration->signingKey());
    }
}
