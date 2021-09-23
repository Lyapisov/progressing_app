<?php

declare(strict_types=1);

namespace App\UserAccess\Infrastructure\Repository\OAuth;

use App\UserAccess\Domain\OAuth\AuthCode;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectRepository;
use League\OAuth2\Server\Entities\AuthCodeEntityInterface;
use League\OAuth2\Server\Exception\UniqueTokenIdentifierConstraintViolationException;
use League\OAuth2\Server\Repositories\AuthCodeRepositoryInterface;

final class AuthCodeRepository implements AuthCodeRepositoryInterface
{
    private EntityManagerInterface $entityManager;
    private ObjectRepository $authCodeRepository;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->authCodeRepository = $this->entityManager->getRepository(AuthCode::class);
    }

    public function getNewAuthCode(): ?AuthCode
    {
        return new AuthCode();
    }

    public function persistNewAuthCode(AuthCodeEntityInterface $authCodeEntity): void
    {
        if ($this->exists($authCodeEntity->getIdentifier())) {
            throw UniqueTokenIdentifierConstraintViolationException::create();
        }

        $this->entityManager->persist($authCodeEntity);
        $this->entityManager->flush();
    }

    public function revokeAuthCode($codeId): void
    {
        if ($code = $this->authCodeRepository->find($codeId)) {
            $this->entityManager->remove($code);
            $this->entityManager->flush();
        }
    }

    public function isAuthCodeRevoked($codeId): bool
    {
        return !$this->exists($codeId);
    }

    private function exists(string $id): bool
    {
        return $this->authCodeRepository->createQueryBuilder('auth')
                ->select('COUNT(auth.identifier)')
                ->andWhere('auth.identifier = :identifier')
                ->setParameter(':identifier', $id)
                ->getQuery()->getSingleScalarResult() > 0;
    }
}
