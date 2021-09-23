<?php

declare(strict_types=1);

namespace App\Profiles\Application\GetById;

use App\Profiles\Infrastructure\Repository\FanRepository;
use App\Profiles\Infrastructure\Repository\MusicianRepository;

final class Handler
{

    public function __construct(
        private FanRepository $fanRepository,
        private MusicianRepository $musicianRepository
    ) {
    }

    public function handle(Query $query): ReadModel
    {
        $fan = $this->fanRepository->getById($query->getId());
        $favoriteMusicians = $this->musicianRepository->findByIds($fan->getFavoriteMusicians());

        $favoriteMusiciansRead = [];
        foreach ($favoriteMusicians as $favoriteMusician) {
            $favoriteMusiciansRead[] = new FavoriteMusicianReadModel($favoriteMusician['id']);
        }

        return new ReadModel(
            $fan->getId(),
            $fan->getName()->getFirstName(),
            $favoriteMusiciansRead
        );
    }
}
