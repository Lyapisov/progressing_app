<?php

declare(strict_types=1);

namespace App\Profiles\Application\Producer\Create;

use App\Profiles\Application\SharedReadModels\Create\ReadModel;
use App\Profiles\Domain\Producer\Producer;
use App\Profiles\Domain\Shared\Address;
use App\Profiles\Domain\Shared\Name;
use App\Profiles\Domain\Shared\PersonalData;
use App\Profiles\Domain\Shared\Phone;
use App\Profiles\Infrastructure\Repository\ProducerRepository;
use App\Util\EventDispatcher\EventDispatcher;

final class Handler
{
    public function __construct(
        private ProducerRepository $producerRepository,
        private EventDispatcher $eventDispatcher,
    ) {
    }

    public function handle(Command $command): ReadModel
    {
        $producer = new Producer(
            $this->producerRepository->generateNewId(),
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

        $this->producerRepository->save($producer);
        $this->eventDispatcher->dispatch($producer->dispatchEvents());

        return new ReadModel($producer->getId());
    }
}
