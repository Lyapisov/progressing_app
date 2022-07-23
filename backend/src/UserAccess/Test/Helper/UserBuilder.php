<?php

declare(strict_types=1);

namespace App\UserAccess\Test\Helper;

use App\UserAccess\Domain\User;
use App\Util\PasswordOperator\HashPasswordOperator;
use DateTimeImmutable;

final class UserBuilder
{
    private const ID = 'ec555a56-7be5-4fed-a559-75acd8cd9ded';
    private const LOGIN = 'Dimua';
    private const EMAIL = 'dimua@rambler.ru';
    private const PASSWORD = 'djI23L;356Ljdgfr';
    private const REGISTRATION_DATE = '2021-10-10';

    private string $id = self::ID;
    private string $login = self::LOGIN;
    private string $email = self::EMAIL;
    private string $password = self::PASSWORD;
    private DateTimeImmutable $registrationDate;

    public function __construct()
    {
        $this->registrationDate = new DateTimeImmutable(self::REGISTRATION_DATE);
    }

    public function withId(string $id): UserBuilder
    {
        $this->id = $id;
        return $this;
    }

    public function withLogin(string $login): UserBuilder
    {
        $this->login = $login;
        return $this;
    }

    public function withEmail(string $email): UserBuilder
    {
        $this->email = $email;
        return $this;
    }

    public function withPassword(string $password): UserBuilder
    {
        $this->password = $password;
        return $this;
    }

    public function withRegistrationDate(DateTimeImmutable $registrationDate): UserBuilder
    {
        $clone = clone $this;
        $clone->registrationDate = $registrationDate;
        return $clone;
    }

    public function build(): User
    {
        $user = new User(
            id:                 $this->id,
            login:              $this->login,
            email:              $this->email,
            password:           $this->password,
            registrationDate:   $this->registrationDate,
            passwordOperator:   new HashPasswordOperator(),
        );

        return $user;
    }
}
