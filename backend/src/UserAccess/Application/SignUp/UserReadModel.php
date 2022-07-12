<?php

declare(strict_types=1);

namespace App\UserAccess\Application\SignUp;

final class UserReadModel
{
    /**
     * @var string
     */
    private string $login;
    /**
     * @var string
     */
    private string $email;
    /**
     * @var string
     */
    private string $role;

    public function __construct(
        string $login,
        string $email,
        string $role,
    ) {
        $this->login = $login;
        $this->email = $email;
        $this->role = $role;
    }

    /**
     * @return string
     */
    public function getLogin(): string
    {
        return $this->login;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getRole(): string
    {
        return $this->role;
    }
}
