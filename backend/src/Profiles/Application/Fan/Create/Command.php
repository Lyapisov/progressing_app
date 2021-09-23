<?php

declare(strict_types=1);

namespace App\Profiles\Application\Fan\Create;

use DateTimeImmutable;

final class Command
{
    public function __construct(
        private string $userId,
        private string $login,
        private string $firstName,
        private ?string $lastName,
        private ?string $fatherName,
        private DateTimeImmutable $birthday,
        private string $address,
        private string $phone,
    ) {
    }

    public function getUserId(): string
    {
        return $this->userId;
    }

    public function getLogin(): string
    {
        return $this->login;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function getFatherName(): ?string
    {
        return $this->fatherName;
    }

    public function getBirthday(): \DateTimeImmutable
    {
        return $this->birthday;
    }

    public function getAddress(): string
    {
        return $this->address;
    }

    public function getPhone(): string
    {
        return $this->phone;
    }
}
