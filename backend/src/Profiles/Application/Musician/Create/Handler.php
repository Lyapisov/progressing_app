<?php

declare(strict_types=1);

namespace App\Profiles\Application\Musician\Create;

use App\Profiles\Application\SharedReadModels\Create\ReadModel;
use App\Profiles\Domain\Musician\Musician;
use App\Profiles\Domain\Shared\Address;
use App\Profiles\Domain\Shared\Name;
use App\Profiles\Domain\Shared\PersonalData;
use App\Profiles\Domain\Shared\Phone;
use App\Profiles\Infrastructure\Repository\MusicianRepository;

final class Handler
{
    public function __construct(
        private MusicianRepository $musicianRepository,
    ) {
    }

    public function handle(Command $command): ReadModel
    {
        $musician = new Musician(
            $this->musicianRepository->generateNewId(),
            $command->getUserId(),
            new PersonalData(
                new Name(
                    $command->getFirstName(),
                    $command->getLastName(),
                    $command->getFatherName(),
                ),
                new Phone($command->getPhone()),
                new Address($command->getAddress()),
                $command->getBirthday(),
            )
        );

        $this->musicianRepository->save($musician);

        return new ReadModel($musician->getId());
    }
}
