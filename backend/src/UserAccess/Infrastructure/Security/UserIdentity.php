<?php

declare(strict_types=1);

namespace App\UserAccess\Infrastructure\Security;

use Symfony\Component\Security\Core\User\UserInterface;

final class UserIdentity implements UserInterface
{
    public function __construct(
        private string $id,
        private string $login,
        private string $password,
        private string $role,
    ) {
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getUsername()
    {
        return $this->login;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getRoles()
    {
        return [$this->role];
    }

    public function getSalt()
    {
        return null;
    }

    public function eraseCredentials()
    {
    }
}
