<?php

declare(strict_types=1);

namespace App\Profiles\Application\Fan\Create;

use App\Profiles\Application\SharedReadModels\Create\ReadModel;
use App\Profiles\Domain\Fan\Fan;
use App\Profiles\Domain\Shared\Address;
use App\Profiles\Domain\Shared\Name;
use App\Profiles\Domain\Shared\PersonalData;
use App\Profiles\Domain\Shared\Phone;
use App\Profiles\Infrastructure\Repository\FanRepository;
use App\Util\EventDispatcher\EventDispatcher;

final class Handler
{
    public function __construct(
        private FanRepository $fanRepository,
        private EventDispatcher $eventDispatcher,
    ) {
    }

    public function handle(Command $command): ReadModel
    {
        $fan = new Fan(
            $this->fanRepository->generateNewId(),
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

        $this->fanRepository->save($fan);
        $this->eventDispatcher->dispatch($fan->dispatchEvents());

        return new ReadModel($fan->getId());
    }
}
