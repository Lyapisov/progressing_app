<?php

declare(strict_types=1);

namespace App\UserAccess\Application\Get\ByCredentials;

final class Query
{
    public function __construct(
        private string $email,
        private string $password,
    ) {
    }

    public function getEmail(): string
    {
        return mb_strtolower($this->email);
    }

    public function getPassword(): string
    {
        return $this->password;
    }
}
