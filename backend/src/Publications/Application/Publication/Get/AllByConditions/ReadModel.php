<?php

declare(strict_types=1);

namespace App\Publications\Application\Publication\Get\AllByConditions;

use DateTimeImmutable;

final class ReadModel
{
    public function __construct(
        private string $id,
        private string $status,
        private string $title,
        private DateTimeImmutable $createdAt,
    ) {
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }
}
