<?php

declare(strict_types=1);

namespace App\SharedKernel\Application\EventHandlers\Profiles\Fan;

use App\Profiles\Domain\Events\FanCreated;
use App\Profiles\Infrastructure\Repository\FanRepository;
use App\Publications\Application\Author\Create\CreateAuthorCommand;
use App\Publications\Application\Author\Create\CreateAuthorHandler;
use App\Publications\Domain\Author\Role;

final class CreatedHandler
{
    public function __construct(
        private FanRepository $fanRepository,
        private CreateAuthorHandler $createAuthorHandler,
    ) {
    }

    public function onEvent(FanCreated $event): void
    {
        $fan = $this->fanRepository->getById($event->getId());

        $this->createAuthorHandler->handle(new CreateAuthorCommand(
            $fan->getUserId(),
            $fan->getPersonalData()->getName()->getFull(),
            Role::fan(),
        ));
    }
}
