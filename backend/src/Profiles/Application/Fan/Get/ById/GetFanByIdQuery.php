<?php

declare(strict_types=1);

namespace App\Profiles\Application\Fan\Get\ById;

final class GetFanByIdQuery
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
