<?php

declare(strict_types=1);

namespace App\Profiles\Test\Helpers;

use App\Profiles\Domain\Producer\Producer;
use App\Profiles\Domain\Shared\Address;
use App\Profiles\Domain\Shared\Name;
use App\Profiles\Domain\Shared\PersonalData;
use App\Profiles\Domain\Shared\Phone;
use DateTimeImmutable;

final class ProducerBuilder
{
    private const ID = '54fb9344-428f-449f-8380-b97fa9a59ac1';
    private const USER_ID = '0cf9773e-869d-46d5-a771-1c5f08296c84';
    private const FIRST_NAME = 'Sadio';
    private const LAST_NAME = 'Mane';
    private const FATHER_NAME = 'Vio';
    private const PHONE_NUMBER = '+79889474747';
    private const ADDRESS = 'Senegal';

    private string $id = self::ID;
    private string $userId = self::USER_ID;
    private PersonalData $personalData;

    public function __construct()
    {
        $this->personalData = new PersonalData(
            new Name(
                self::FIRST_NAME,
                self::LAST_NAME,
                self::FATHER_NAME,
            ),
            new Phone(
                self::PHONE_NUMBER
            ),
            new Address(
                self::ADDRESS
            ),
            new DateTimeImmutable('10-10-1995'),
        );
    }

    public function withId(string $id): ProducerBuilder
    {
        $this->id = $id;
        return $this;
    }

    public function withUserId(string $userId): ProducerBuilder
    {
        $this->userId = $userId;
        return $this;
    }

    public function withPersonalData(PersonalData $personalData): ProducerBuilder
    {
        $this->personalData = $personalData;
        return $this;
    }

    public function build(): Producer
    {
        $producer = new Producer(
            $this->id,
            $this->userId,
            $this->personalData,
        );

        return $producer;
    }
}
