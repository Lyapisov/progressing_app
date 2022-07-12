<?php

declare(strict_types=1);

namespace App\UserAccess\Infrastructure\Repository;

use App\UserAccess\Domain\User;
use App\UserAccess\Domain\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectRepository;
use Ramsey\Uuid\Uuid;

final class DoctrineUserRepository implements UserRepository
{
    private EntityManagerInterface $entityManager;
    private ObjectRepository $userRepository;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->userRepository = $this->entityManager->getRepository(User::class);
    }

    public function findById(string $id): ?User
    {
        return $this->userRepository->find($id);
    }

    public function findByEmail(string $email): ?User
    {
        return $this->userRepository->findOneBy(['email' => $email]);
    }

    public function findByLogin(string $login): ?User
    {
        return $this->userRepository->findOneBy(['login' => $login]);
    }

    /**
     * @param string $login
     * @return bool
     */
    public function existsByLogin(string $login): bool
    {
        $user = $this->userRepository->findByLogin($login);
        return (bool)$user;
    }

    /**
     * @param string $email
     * @return bool
     */
    public function existsByEmail(string $email): bool
    {
        $user = $this->userRepository->findByEmail($email);
        return (bool)$user;
    }

    public function generateNewId(): string
    {
        return Uuid::uuid4()->toString();
    }

    public function save(User $user): void
    {
        $this->entityManager->persist($user);
        $this->entityManager->flush();
    }

}
