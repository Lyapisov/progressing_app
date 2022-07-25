<?php

declare(strict_types=1);

namespace App\Profiles\Infrastructure\Repository;

use App\Profiles\Domain\Producer\Producer;
use App\SharedKernel\Domain\Exceptions\NotFoundException;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectRepository;
use Ramsey\Uuid\Uuid;

final class ProducerRepository
{
    /**
     * @var ObjectRepository<Producer>
     */
    private ObjectRepository $repository;

    public function __construct(
        private EntityManagerInterface $em
    ) {
        $this->repository = $this->em->getRepository(Producer::class);
    }

    public function getById(string $id): Producer
    {
        $producer = $this->repository->find($id);
        if (is_null($producer)) {
            throw new NotFoundException("Продюсер с идентификатором: {$id} не найден.");
        }

        return $producer;
    }

    public function findById(string $id): ?Producer
    {
        return $this->repository->find($id);
    }

    public function findByUserId(string $userId): ?Producer
    {
        return $this->repository->findOneBy(['userId' => $userId]);
    }

    public function generateNewId(): string
    {
        return Uuid::uuid4()->toString();
    }

    public function save(Producer $producer): void
    {
        $this->em->persist($producer);
        $this->em->flush();
    }
}
