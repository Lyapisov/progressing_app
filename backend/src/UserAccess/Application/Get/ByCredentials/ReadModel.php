<?php

declare(strict_types=1);

namespace App\UserAccess\Application\Get\ByCredentials;

final class ReadModel
{
    public function __construct(
        private string $id,
        private string $login,
        private string $email
    ) {
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getLogin(): string
    {
        return $this->login;
    }

    public function getEmail(): string
    {
        return $this->email;
    }
}
