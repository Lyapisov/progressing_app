<?php

declare(strict_types=1);

namespace App\SharedKernel\Domain\Auth;

final class UserIdentity
{
    public function __construct(
        private string $id,
    ) {
    }

    public function getId(): string
    {
        return $this->id;
    }
}
