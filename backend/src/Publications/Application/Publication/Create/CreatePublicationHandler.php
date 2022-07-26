<?php

declare(strict_types=1);

namespace App\Publications\Application\Publication\Create;

use App\Publications\Domain\Publication\Content;
use App\Publications\Domain\Publication\Image;
use App\Publications\Domain\Publication\Likes;
use App\Publications\Domain\Publication\Publication;
use App\Publications\Domain\Publication\Status;
use App\Publications\Infrastructure\Repositories\PublicationRepository;
use App\Util\DateProvider\DateProvider;

final class CreatePublicationHandler
{
    public function __construct(
        private PublicationRepository $publicationRepository,
        private DateProvider $dateProvider,
    ) {
    }

    public function handle(CreatePublicationCommand $command): ReadModel
    {
        $publication = new Publication(
            $this->publicationRepository->generateNewId(),
            $command->getAuthorId(),
            new Content(
                $command->getContentTitle(),
                $command->getContentText(),
                new Image($command->getContentImageId())
            ),
            Likes::createEmpty(),
            new Status(),
            $this->dateProvider->getNow(),
        );

        $this->publicationRepository->save($publication);

        return new ReadModel($publication->getId());
    }
}
