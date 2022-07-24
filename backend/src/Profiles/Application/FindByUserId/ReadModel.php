<?php

declare(strict_types=1);

namespace App\Profiles\Application\FindByUserId;

final class ReadModel
{
    public function __construct(
        private bool $found,
        private bool $fan,
        private bool $producer,
        private bool $musician,
    ) {
    }

    public function isFound(): bool
    {
        return $this->found;
    }

    public function isFan(): bool
    {
        return $this->fan;
    }

    public function isProducer(): bool
    {
        return $this->producer;
    }

    public function isMusician(): bool
    {
        return $this->musician;
    }
}
