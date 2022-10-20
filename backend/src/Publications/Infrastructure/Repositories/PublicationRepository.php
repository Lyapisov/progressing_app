<?php

declare(strict_types=1);

namespace App\Publications\Infrastructure\Repositories;

use App\Publications\Domain\Publication\Publication;
use App\SharedKernel\Domain\Exceptions\NotFoundException;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectRepository;
use Ramsey\Uuid\Uuid;

final class PublicationRepository
{
    /**
     * @var ObjectRepository<Publication>
     */
    private ObjectRepository $repository;

    public function __construct(
        private EntityManagerInterface $entityManager
    ) {
        $this->repository = $this->entityManager->getRepository(Publication::class);
    }

    public function getById(string $id): Publication
    {
        /** @var Publication|null $publication */
        $publication = $this->repository->find($id);
        if (is_null($publication)) {
            throw new NotFoundException("Публикация с идентификатором: {$id} не найдена.");
        }

        return $publication;
    }

    public function findById(string $id): ?Publication
    {
        return $this->repository->find($id);
    }

    public function generateNewId(): string
    {
        return Uuid::uuid4()->toString();
    }

    public function save(Publication $publication): void
    {
        $this->entityManager->persist($publication);
        $this->entityManager->flush();
    }
}
