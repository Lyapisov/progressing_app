<?php

declare(strict_types=1);

namespace App\UserAccess\Test\Helper;

use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Lcobucci\JWT\Configuration;
use Lcobucci\JWT\Signer\Key\InMemory;
use Lcobucci\JWT\Signer\Key\LocalFileReference;
use Lcobucci\JWT\Signer\Rsa\Sha256;
use League\OAuth2\Server\CryptKey;
use Trikoder\Bundle\OAuth2Bundle\Model\AccessToken;
use Trikoder\Bundle\OAuth2Bundle\Model\Client;
use Trikoder\Bundle\OAuth2Bundle\Model\RefreshToken;

final class OAuthHeader
{
    /**
     * @param string $userLogin
     * @param EntityManagerInterface $em
     * @return string[]
     * @throws \Exception
     */
    public static function for(string $userLogin, EntityManagerInterface $em): array
    {
        $client = new Client('oauth', 'secret');

        $accessToken = new AccessToken(
            bin2hex(random_bytes(40)),
            new DateTimeImmutable('2300-12-31 21:00:10'),
            $client,
            $userLogin,
            []
        );

        /** @phpstan-ignore-next-line */
        $privateKey = new CryptKey(getenv('OAUTH_PRIVATE_KEY'), null, false);
        $jwtConfiguration = Configuration::forAsymmetricSigner(
            new Sha256(),
            LocalFileReference::file($privateKey->getKeyPath(), $privateKey->getPassPhrase() ?? ''),
            InMemory::plainText('')
        );

        $refreshToken = new RefreshToken(
            '24625b91-71be-4a5c-a841-1c977dd3e9d9',
            new DateTimeImmutable('2300-12-31 21:00:10'),
            $accessToken
        );

        $em->persist($client);
        $em->persist($accessToken);
        $em->persist($refreshToken);
        $em->flush();

        return ['HTTP_AUTHORIZATION' => 'Bearer ' .  $jwtConfiguration->builder()
                ->permittedFor($accessToken->getClient()->getIdentifier())
                ->identifiedBy($accessToken->getIdentifier())
                ->issuedAt(new DateTimeImmutable())
                ->canOnlyBeUsedAfter(new DateTimeImmutable())
                ->expiresAt(DateTimeImmutable::createFromInterface($accessToken->getExpiry()))
                ->relatedTo((string) $accessToken->getUserIdentifier())
                ->withClaim('scopes', $accessToken->getScopes())
                ->getToken($jwtConfiguration->signer(), $jwtConfiguration->signingKey())->toString()];
    }
}
