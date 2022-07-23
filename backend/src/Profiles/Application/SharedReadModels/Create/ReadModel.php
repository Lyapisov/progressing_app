<?php

declare(strict_types=1);

namespace App\Profiles\Application\SharedReadModels\Create;

final class ReadModel
{
    public function __construct(
        private string $id,
    )
    {
    }

    public function getId(): string
    {
        return $this->id;
    }
}
