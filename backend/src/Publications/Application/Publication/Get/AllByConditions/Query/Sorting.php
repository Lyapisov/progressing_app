<?php

declare(strict_types=1);

namespace App\Publications\Application\Publication\Get\AllByConditions\Query;

final class Sorting
{
    public function __construct(
        private ?string $createdAt,
    ) {
    }

    public function getCreatedAt(): ?string
    {
        return $this->createdAt;
    }
}
