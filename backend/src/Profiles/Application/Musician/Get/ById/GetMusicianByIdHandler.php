<?php

declare(strict_types=1);

namespace App\Profiles\Application\Musician\Get\ById;

use App\Profiles\Infrastructure\Repository\MusicianRepository;

final class GetMusicianByIdHandler
{
    public function __construct(
        private MusicianRepository $musicianRepository
    ) {
    }

    public function handle(GetMusicianByIdQuery $query): ReadModel
    {
        $fan = $this->musicianRepository->getById($query->getId());

        return new ReadModel(
            $fan->getId(),
            $fan->getPersonalData()->getName()->getFirst(),
            $fan->getPersonalData()->getName()->getLast(),
            $fan->getPersonalData()->getName()->getFather(),
            $fan->getPersonalData()->getPhone()->getNumber(),
            $fan->getPersonalData()->getAddress()->getAddress(),
            $fan->getPersonalData()->getBirthday(),
        );
    }
}
