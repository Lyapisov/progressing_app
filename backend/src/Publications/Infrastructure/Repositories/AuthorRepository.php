<?php

declare(strict_types=1);

namespace App\Publications\Infrastructure\Repositories;

use App\Publications\Domain\Author\Author;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectRepository;

final class AuthorRepository
{
    /**
     * @var ObjectRepository<Author>
     */
    private ObjectRepository $repository;

    public function __construct(
        private EntityManagerInterface $entityManager
    ) {
        $this->repository = $this->entityManager->getRepository(Author::class);
    }

    public function findById(string $id): ?Author
    {
        return $this->repository->find($id);
    }

    public function save(Author $author): void
    {
        $this->entityManager->persist($author);
        $this->entityManager->flush();
    }
}
