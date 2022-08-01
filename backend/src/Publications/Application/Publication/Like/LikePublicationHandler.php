<?php

namespace App\Publications\Application\Publication\Like;

use App\Publications\Infrastructure\Repositories\PublicationRepository;

class LikePublicationHandler
{
    public function __construct(
        private PublicationRepository $publicationRepository,
    ) {
    }

    public function handle(LikePublicationCommand $command): void
    {
        $publication = $this->publicationRepository->getById($command->getPublicationId());

        $publication->like($command->getLikeAuthorId());
    }
}
