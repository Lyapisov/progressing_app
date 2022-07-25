<?php

declare(strict_types=1);

namespace App\Profiles\Infrastructure\Repository;

use App\Profiles\Domain\Musician\Musician;
use App\SharedKernel\Domain\Exceptions\NotFoundException;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectRepository;
use Ramsey\Uuid\Uuid;

final class MusicianRepository
{
    /**
     * @var ObjectRepository<Musician>
     */
    private ObjectRepository $repository;

    public function __construct(
        private EntityManagerInterface $em
    ) {
        $this->repository = $this->em->getRepository(Musician::class);
    }

    public function getById(string $id): Musician
    {
        $musician = $this->repository->find($id);
        if (is_null($musician)) {
            throw new NotFoundException("Музыкант с идентификатором: {$id} не найден.");
        }

        return $musician;
    }

    public function findById(string $id): ?Musician
    {
        return $this->repository->find($id);
    }

    public function findByUserId(string $userId): ?Musician
    {
        return $this->repository->findOneBy(['userId' => $userId]);
    }

    public function generateNewId(): string
    {
        return Uuid::uuid4()->toString();
    }

    public function save(Musician $musician): void
    {
        $this->em->persist($musician);
        $this->em->flush();
    }
}
