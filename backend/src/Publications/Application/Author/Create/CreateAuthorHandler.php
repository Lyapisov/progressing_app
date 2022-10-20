<?php

declare(strict_types=1);

namespace App\Publications\Application\Author\Create;

use App\Publications\Domain\Author\Author;
use App\Publications\Infrastructure\Repositories\AuthorRepository;

final class CreateAuthorHandler
{
    public function __construct(
        private AuthorRepository $authorRepository,
    ) {
    }

    public function handle(CreateAuthorCommand $command): void
    {
        $author = new Author(
            $command->getId(),
            $command->getFullName(),
            $command->getRole(),
        );

        $this->authorRepository->save($author);
    }
}
