<?php

declare(strict_types=1);

namespace App\Publications\Application\Author\Create;

use App\Publications\Domain\Author\Role;

final class CreateAuthorCommand
{
    public function __construct(
        private string $id,
        private string $fullName,
        private Role $role,
    ) {
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getFullName(): string
    {
        return $this->fullName;
    }

    public function getRole(): Role
    {
        return $this->role;
    }
}
