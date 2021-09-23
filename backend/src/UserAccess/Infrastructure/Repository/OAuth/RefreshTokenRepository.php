<?php

declare(strict_types=1);

namespace App\UserAccess\Infrastructure\Repository\OAuth;

use App\UserAccess\Domain\OAuth\RefreshToken;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectRepository;
use League\OAuth2\Server\Entities\RefreshTokenEntityInterface;
use League\OAuth2\Server\Exception\UniqueTokenIdentifierConstraintViolationException;
use League\OAuth2\Server\Repositories\RefreshTokenRepositoryInterface;

final class RefreshTokenRepository implements RefreshTokenRepositoryInterface
{
    private EntityManagerInterface $entityManager;
    private ObjectRepository $refreshTokenRepository;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->refreshTokenRepository = $this->entityManager->getRepository(RefreshToken::class);
    }

    public function getNewRefreshToken(): ?RefreshToken
    {
        return new RefreshToken();
    }

    public function persistNewRefreshToken(RefreshTokenEntityInterface $refreshTokenEntity): void
    {
        if ($this->exists($refreshTokenEntity->getIdentifier())) {
            throw UniqueTokenIdentifierConstraintViolationException::create();
        }

        $this->entityManager->persist($refreshTokenEntity);
        $this->entityManager->flush();
    }

    public function revokeRefreshToken($tokenId): void
    {
        if ($code = $this->refreshTokenRepository->find($tokenId)) {
            $this->entityManager->remove($code);
            $this->entityManager->flush();
        }
    }

    public function isRefreshTokenRevoked($tokenId): bool
    {
        return !$this->exists($tokenId);
    }

    private function exists(string $id): bool
    {
        return $this->refreshTokenRepository->createQueryBuilder('token')
                ->select('COUNT(token.identifier)')
                ->andWhere('token.identifier = :identifier')
                ->setParameter(':identifier', $id)
                ->getQuery()->getSingleScalarResult() > 0;
    }
}
