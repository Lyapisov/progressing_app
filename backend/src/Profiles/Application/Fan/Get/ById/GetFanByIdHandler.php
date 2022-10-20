<?php

declare(strict_types=1);

namespace App\Profiles\Application\Fan\Get\ById;

use App\Profiles\Infrastructure\Repository\FanRepository;

final class GetFanByIdHandler
{
    public function __construct(
        private FanRepository $fanRepository
    ) {
    }

    public function handle(GetFanByIdQuery $query): ReadModel
    {
        $fan = $this->fanRepository->getById($query->getId());

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
