<?php

declare(strict_types=1);

namespace App\Profiles\Application\Fan\Create;

use App\Profiles\Domain\Fan\Fan;
use App\Profiles\Domain\Shared\Address;
use App\Profiles\Domain\Shared\Name;
use App\Profiles\Domain\Shared\Phone;
use App\Profiles\Infrastructure\Repository\FanRepository;

final class Handler
{
    public function __construct(
        private FanRepository $fanRepository,
    ) {
    }

    public function handle(Command $command): ReadModel
    {
        $fan = new Fan(
            $this->fanRepository->generateNewId(),
            $command->getUserId(),
            new Name(
                $command->getLogin(),
                $command->getFirstName(),
                $command->getLastName(),
                $command->getFatherName(),
            ),
            $command->getBirthday(),
            new Address($command->getAddress()),
            new Phone($command->getPhone()),
        );

        $this->fanRepository->save($fan);

        return new ReadModel($fan->getId());
    }
}
