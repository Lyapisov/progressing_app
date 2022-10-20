<?php

declare(strict_types=1);

namespace App\SharedKernel\Application\EventHandlers\Profiles\Musician;

use App\Profiles\Domain\Events\MusicianCreated;
use App\Profiles\Infrastructure\Repository\MusicianRepository;
use App\Publications\Application\Author\Create\CreateAuthorCommand;
use App\Publications\Application\Author\Create\CreateAuthorHandler;
use App\Publications\Domain\Author\Role;

final class CreatedHandler
{
    public function __construct(
        private MusicianRepository $musicianRepository,
        private CreateAuthorHandler $createAuthorHandler,
    ) {
    }

    public function onEvent(MusicianCreated $event): void
    {
        $fan = $this->musicianRepository->getById($event->getId());

        $this->createAuthorHandler->handle(new CreateAuthorCommand(
            $fan->getUserId(),
            $fan->getPersonalData()->getName()->getFull(),
            Role::musician(),
        ));
    }
}
