<?php

declare(strict_types=1);

namespace App\Profiles\Application\Musician\Get\ById;

use DateTimeImmutable;

final class ReadModel
{
    public function __construct(
        private string $id,
        private string $firstName,
        private string $lastName,
        private string $fatherName,
        private string $phoneNumber,
        private string $address,
        private DateTimeImmutable $birthday,
    ) {
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function getFatherName(): string
    {
        return $this->fatherName;
    }

    public function getPhoneNumber(): string
    {
        return $this->phoneNumber;
    }

    public function getAddress(): string
    {
        return $this->address;
    }

    public function getBirthday(): DateTimeImmutable
    {
        return $this->birthday;
    }
}
