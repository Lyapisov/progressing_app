<?php

declare(strict_types=1);

namespace App\Profiles\Infrastructure\Repository;

use App\Profiles\Domain\Fan\Fan;
use App\SharedKernel\Domain\Exceptions\NotFoundException;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectRepository;
use Ramsey\Uuid\Uuid;

final class FanRepository
{
    private ObjectRepository $repository;

    public function __construct(
        private EntityManagerInterface $em
    ) {
        $this->repository = $this->em->getRepository(Fan::class);
    }

    public function generateNewId(): string
    {
        return Uuid::uuid4()->toString();
    }

    public function findById(string $id): ?Fan
    {
        return $this->repository->find($id);
    }

    public function getById(string $id): Fan
    {
        $fan = $this->repository->find($id);
        if (is_null($fan)) {
            throw new NotFoundException("Пользователь с идентификатором: {$id} не найден.");
        }

        return $fan;
    }

    public function save(Fan $fan): void
    {
        $this->em->persist($fan);
        $this->em->flush();
    }
}
