<?php

declare(strict_types=1);

namespace App\Publications\Application\Publication\Get\AllByConditions;

use App\Publications\Application\Publication\Get\AllByConditions\Query\Filters;
use App\Publications\Application\Publication\Get\AllByConditions\Query\GetPublicationsByConditionsQuery;
use App\Publications\Application\Publication\Get\AllByConditions\Query\Sorting;
use App\Publications\Domain\Publication\Publication;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\QueryBuilder;

final class GetPublicationsByConditionsHandler
{
    public function __construct(
        private EntityManagerInterface $entityManager,
    ) {
    }

    /**
     * @param GetPublicationsByConditionsQuery $query
     * @return ReadModel[]
     */
    public function handle(GetPublicationsByConditionsQuery $query): array
    {
        $publicationsData = $this->getPublicationsData($query);

        return array_map(
            fn(array $data) =>
            new ReadModel(
                $data['id'],
                $data['status'],
                $data['title'],
                $data['countLikes'],
                $data['createdAt'],
            ),
            $publicationsData,
        );
    }

    /**
     * @param GetPublicationsByConditionsQuery $query
     * @return array<int,mixed>
     */
    private function getPublicationsData(GetPublicationsByConditionsQuery $query): array
    {
        $qb = $this->entityManager->createQueryBuilder();
        $qb
            ->select(
                'publication.id',
                'publication.status.name as status',
                'publication.content.title as title',
                'publication.createdAt as createdAt',
                'publication.likes.count as countLikes',
            )
            ->from(Publication::class, 'publication');

        $qb = $this->filtering($qb, $query->getFilters());
        $qb = $this->sorting($qb, $query->getSorting());

        return $qb->getQuery()->getArrayResult();
    }

    private function filtering(QueryBuilder $qb, Filters $filters): QueryBuilder
    {
        if (!empty($filters->getAuthors())) {
            $qb
                ->andWhere('publication.authorId IN (:authors)')
                ->setParameter('authors', $filters->getAuthors());
        }

        if (!empty($filters->getStatuses())) {
            $qb
                ->andWhere('publication.status.name IN (:statuses)')
                ->setParameter('statuses', $filters->getStatuses());
        }

        return $qb;
    }

    private function sorting(QueryBuilder $qb, Sorting $sorting): QueryBuilder
    {
        if (!is_null($sorting->getCreatedAt())) {
            $qb->addOrderBy('createdAt', $sorting->getCreatedAt());
        }

        return $qb;
    }
}
