<?php

declare(strict_types=1);

namespace App\UserAccess\Infrastructure\Security;

use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @method string getUserIdentifier()
 */
final class UserIdentity implements UserInterface
{
    public function __construct(
        private string $id,
        private string $login,
        private string $password,
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

    public function getSalt()
    {
        return null;
    }

    public function getRoles()
    {
        return['ROLE_USER'];
    }

    public function eraseCredentials(): void
    {
    }
}
