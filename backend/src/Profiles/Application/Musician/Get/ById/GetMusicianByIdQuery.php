<?php

declare(strict_types=1);

namespace App\Profiles\Application\Musician\Get\ById;

final class GetMusicianByIdQuery
{
    public function __construct(
        private string $id
    ) {
    }

    public function getId(): string
    {
        return $this->id;
    }
}
