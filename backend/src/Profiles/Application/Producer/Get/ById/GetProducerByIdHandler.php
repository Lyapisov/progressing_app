<?php

declare(strict_types=1);

namespace App\Profiles\Application\Producer\Get\ById;

use App\Profiles\Infrastructure\Repository\ProducerRepository;

final class GetProducerByIdHandler
{
    public function __construct(
        private ProducerRepository $producerRepository
    ) {
    }

    public function handle(GetProducerByIdQuery $query): ReadModel
    {
        $fan = $this->producerRepository->getById($query->getId());

        return new ReadModel(
            $fan->getId(),
            $fan->getPersonalData()->getName()->getFirstName(),
            $fan->getPersonalData()->getName()->getLastName(),
            $fan->getPersonalData()->getName()->getFatherName(),
            $fan->getPersonalData()->getPhone()->getNumber(),
            $fan->getPersonalData()->getAddress()->getAddress(),
            $fan->getPersonalData()->getBirthday(),
        );
    }
}
