<?php

declare(strict_types=1);

namespace App\Profiles\Infrastructure\Repository;

use App\Profiles\Domain\Musician\Musician;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectRepository;

final class MusicianRepository
{
    private ObjectRepository $repository;

    public function __construct(
        private EntityManagerInterface $em
    ) {
        $this->repository = $this->em->getRepository(Musician::class);
    }

    public function findById(string $id): ?Musician
    {
        return $this->repository->find($id);
    }

    /**
     * @param array $ids
     * @return Musician[]
     */
    public function findByIds(array $ids): array
    {
        $qb = $this->em->createQueryBuilder()
            ->select('mus')
            ->from(Musician::class, 'mus')
            ->where('mus.id IN (:ids)')
            ->setParameter('ids', $ids);

        return $qb->getQuery()->getArrayResult();
    }
}
