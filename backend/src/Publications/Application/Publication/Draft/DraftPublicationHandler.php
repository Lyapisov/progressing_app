<?php

namespace App\Publications\Application\Publication\Draft;

use App\Publications\Infrastructure\Repositories\PublicationRepository;

class DraftPublicationHandler
{
    public function __construct(
        private PublicationRepository $publicationRepository
    ) {
    }

    public function handle(DraftPublicationCommand $command): void
    {
        $publication = $this->publicationRepository->getById($command->getId());

        $publication->draft();

        $this->publicationRepository->save($publication);
    }
}