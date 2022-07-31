<?php

namespace App\Publications\Application\Publication\Publish;

use App\Publications\Infrastructure\Repositories\PublicationRepository;

class PublishPublicationHandler
{
    public function __construct(
        private PublicationRepository $publicationRepository,
    ) {
    }

    public function handle(PublishPublicationCommand $command): void
    {
        $publication = $this->publicationRepository->getById($command->getId());

        $publication->publish();

        $this->publicationRepository->save($publication);
    }
}