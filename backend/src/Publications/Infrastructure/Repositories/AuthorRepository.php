<?php

declare(strict_types=1);

namespace App\Publications\Infrastructure\Repositories;

use App\Publications\Domain\Author\Author;
use App\SharedKernel\Domain\Exceptions\NotFoundException;
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

    public function getById(string $id): Author
    {
        /** @var Author|null $author */
        $author = $this->repository->find($id);
        if (is_null($author)) {
            throw new NotFoundException("Автор с идентификатором: {$id} не найден.");
        }

        return $author;
    }

    public function save(Author $author): void
    {
        $this->entityManager->persist($author);
        $this->entityManager->flush();
    }
}
