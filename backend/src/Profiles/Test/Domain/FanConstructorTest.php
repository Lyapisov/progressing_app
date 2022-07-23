<?php

declare(strict_types=1);

namespace App\Profiles\Test\Domain;

use App\Profiles\Domain\Fan\Fan;
use App\Profiles\Domain\Shared\Address;
use App\Profiles\Domain\Shared\Name;
use App\Profiles\Domain\Shared\PersonalData;
use App\Profiles\Domain\Shared\Phone;
use DateTimeImmutable;
use DomainException;
use PHPUnit\Framework\TestCase;

final class FanConstructorTest extends TestCase
{
    /**
     * @dataProvider validDataProvider
     */
    public function testSuccess(
        string $id,
        string $userId,
        string $firstName,
        ?string $lastName,
        ?string $fatherName,
        string $birthday,
        string $address,
        string $number,
    ): void
    {
        $fan = new Fan(
            $id,
            $userId,
            new PersonalData(
                new Name($firstName, $lastName, $fatherName),
                new Phone($number),
                new Address($address),
                new DateTimeImmutable($birthday),
            )
        );

        $this->assertEquals($id, $fan->getId());
        $this->assertEquals($userId, $fan->getUserId());
        $this->assertEquals($firstName, $fan->getPersonalData()->getName()->getFirstName());
        $this->assertEquals($lastName, $fan->getPersonalData()->getName()->getLastName());
        $this->assertEquals($fatherName, $fan->getPersonalData()->getName()->getFatherName());
        $this->assertEquals(new DateTimeImmutable($birthday), $fan->getPersonalData()->getBirthday());
        $this->assertEquals($address, $fan->getPersonalData()->getAddress()->getAddress());
        $this->assertEquals($number, $fan->getPersonalData()->getPhone()->getNumber());
    }

    public function testIncorrectId(): void
    {
        $this->expectExceptionObject(
            new DomainException(
                'Идентификатор фаната должен соответствовать формату uuid.'
            )
        );

        $fan = new Fan(
            $id = '',
            $userId = 'a42546e0-31ad-4a94-b2f7-19c6e755218e',
            new PersonalData(
                new Name(
                    $firstName = 'firstName',
                    $lastName = 'lastName',
                    $fatherName = 'fatherName',
                ),
                new Phone($number = '+79889474747'),
                new Address($address = 'Address'),
                new DateTimeImmutable($birthday = '1995-10-10'),
            )
        );
    }

    public function testIncorrectUserId(): void
    {
        $this->expectExceptionObject(
            new DomainException(
                'Идентификатор пользователя должен соответствовать формату uuid.'
            )
        );

        $fan = new Fan(
            $id = '283758da-fb37-43db-abb0-0a917fdaa527',
            $userId = '',
            new PersonalData(
                new Name(
                    $firstName = 'firstName',
                    $lastName = 'lastName',
                    $fatherName = 'fatherName',
                ),
                new Phone($number = '+79889474747'),
                new Address($address = 'Address'),
                new DateTimeImmutable($birthday = '1995-10-10'),
            )
        );
    }

    public function testEmptyFirstName(): void
    {
        $this->expectExceptionObject(
            new DomainException(
                'Имя не может быть пустым.'
            )
        );

        $fan = new Fan(
            $id = '283758da-fb37-43db-abb0-0a917fdaa527',
            $userId = 'a42546e0-31ad-4a94-b2f7-19c6e755218e',
            new PersonalData(
                new Name(
                    $firstName = '',
                    $lastName = 'lastName',
                    $fatherName = 'fatherName',
                ),
                new Phone($number = '+79889474747'),
                new Address($address = 'Address'),
                new DateTimeImmutable($birthday = '1995-10-10'),
            )
        );
    }

    public function testIncorrectNumber(): void
    {
        $this->expectExceptionObject(
            new DomainException(
                'Номер телефона должен соответствовать формату +7NNNNNNNNNN'
            )
        );

        $fan = new Fan(
            $id = '283758da-fb37-43db-abb0-0a917fdaa527',
            $userId = 'a42546e0-31ad-4a94-b2f7-19c6e755218e',
            new PersonalData(
                new Name(
                    $firstName = 'firstName',
                    $lastName = 'lastName',
                    $fatherName = 'fatherName',
                ),
                new Phone($number = '79889488874747'),
                new Address($address = 'Address'),
                new DateTimeImmutable($birthday = '1995-10-10'),
            )
        );
    }

    public function validDataProvider(): array
    {
        return [
            'Все данные' => [
                'id' => '283758da-fb37-43db-abb0-0a917fdaa527',
                'userId' => 'a42546e0-31ad-4a94-b2f7-19c6e755218e',
                'firstName' => 'firstName',
                'lastName' => 'lastName',
                'fatherName' => 'fatherName',
                'birthday' => '1995-10-10',
                'address' => 'Address',
                'number' => '+79889474747'
            ],
            'Без фамилии' => [
                'id' => '283758da-fb37-43db-abb0-0a917fdaa527',
                'userId' => 'a42546e0-31ad-4a94-b2f7-19c6e755218e',
                'firstName' => 'firstName',
                'lastName' => '',
                'fatherName' => 'fatherName',
                'birthday' => '1995-10-10',
                'address' => 'Address',
                'number' => '+79889474747'
            ],
            'Без Отчества' => [
                'id' => '283758da-fb37-43db-abb0-0a917fdaa527',
                'userId' => 'a42546e0-31ad-4a94-b2f7-19c6e755218e',
                'firstName' => 'firstName',
                'lastName' => 'lastName',
                'fatherName' => '',
                'birthday' => '1995-10-10',
                'address' => 'Address',
                'number' => '+79889474747'
            ],
        ];
    }
}
