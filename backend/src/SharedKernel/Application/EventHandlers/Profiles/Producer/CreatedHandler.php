<?php

declare(strict_types=1);

namespace App\SharedKernel\Application\EventHandlers\Profiles\Producer;

use App\Profiles\Domain\Events\ProducerCreated;
use App\Profiles\Infrastructure\Repository\ProducerRepository;
use App\Publications\Application\Author\Create\CreateAuthorCommand;
use App\Publications\Application\Author\Create\CreateAuthorHandler;
use App\Publications\Domain\Author\Role;

final class CreatedHandler
{
    public function __construct(
        private ProducerRepository $producerRepository,
        private CreateAuthorHandler $createAuthorHandler,
    ) {
    }

    public function onEvent(ProducerCreated $event): void
    {
        $fan = $this->producerRepository->getById($event->getId());

        $this->createAuthorHandler->handle(new CreateAuthorCommand(
            $fan->getUserId(),
            $fan->getPersonalData()->getName()->getFull(),
            Role::producer(),
        ));
    }
}
