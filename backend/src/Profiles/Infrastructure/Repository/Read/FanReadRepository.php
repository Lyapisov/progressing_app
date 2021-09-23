<?php

declare(strict_types=1);

namespace App\Profiles\Infrastructure\Repository\Read;

use App\Profiles\Domain\Fan\Fan;
use App\Profiles\Domain\Musician\Musician;
use Doctrine\DBAL\Connection;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Query\Expr\Join;
use Doctrine\Persistence\ObjectRepository;

final class FanReadRepository
{
    private ObjectRepository $repository;

    public function __construct(
        private EntityManagerInterface $em
    ) {
        $this->repository = $this->em->getRepository(Fan::class);
    }

    public function getById(string $id): ?Fan
    {
//        $favoriteMusician = $this->em->createQueryBuilder()
//            ->select('fan.favoriteMusicians')
//            ->from(Fan::class, 'fan')
//            ->where('fan.id = :id')
//            ->setParameter('id', $id)
//            ->getQuery()
//            ->getResult();
//
//        $ids = $favoriteMusician[0]['favoriteMusicians'];

//        $qb = $this->em->createQueryBuilder()
//            ->select('fan.id as id')
//            ->from(Fan::class, 'fan')
//            ->where('fan.id = :id')
//            ->setParameter('id', $id);
//
//        return $qb->getQuery()->getArrayResult();

        return $this->repository->find($id);
    }
}
