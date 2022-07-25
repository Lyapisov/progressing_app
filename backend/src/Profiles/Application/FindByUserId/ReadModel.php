<?php

declare(strict_types=1);

namespace App\Profiles\Application\FindByUserId;

final class ReadModel
{
    public function __construct(
        private bool $found,
        private ?string $fanId,
        private ?string $musicianId,
        private ?string $producerId,
    ) {
    }

    public function isFound(): bool
    {
        return $this->found;
    }

    public function getFanId(): ?string
    {
        return $this->fanId;
    }

    public function getProducerId(): ?string
    {
        return $this->producerId;
    }

    public function getMusicianId(): ?string
    {
        return $this->musicianId;
    }
}
