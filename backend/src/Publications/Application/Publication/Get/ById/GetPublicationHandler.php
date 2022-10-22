<?php

namespace App\Publications\Application\Publication\Get\ById;

use App\Publications\Infrastructure\Repositories\PublicationRepository;
use App\SharedKernel\Domain\Exceptions\NotFoundException;

class GetPublicationHandler
{
    public function __construct(
        private PublicationRepository $publicationRepository,
    ) {
    }

    public function handle(GetPublicationQuery $query): ReadModel
    {
        $publication = $this->publicationRepository->findById($query->getId());

        if (is_null($publication)) {
            throw new NotFoundException(
                "Публикация с идентификатором {$query->getId()} не найдена."
            );
        }

        return new ReadModel(
            $publication->getId(),
            $publication->getAuthorId(),
            $publication->getContent()->getTitle(),
            $publication->getContent()->getText(),
            $publication->getContent()->getImage()->getId(),
            $publication->getLikes()->getCount(),
            $publication->getStatus()->getName(),
            $publication->getCreatedAt(),
        );
    }
}
