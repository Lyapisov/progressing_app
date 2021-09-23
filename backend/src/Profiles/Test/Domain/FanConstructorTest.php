<?php

declare(strict_types=1);

namespace App\Profiles\Test\Domain;

use App\Profiles\Domain\Fan\Fan;
use App\Profiles\Domain\Shared\Address;
use App\Profiles\Domain\Shared\Name;
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
        string $login,
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
            new Name($login, $firstName, $lastName, $fatherName),
            new DateTimeImmutable($birthday),
            new Address($address),
            new Phone($number),
        );

        $this->assertEquals($id, $fan->getId());
        $this->assertEquals($userId, $fan->getUserId());
        $this->assertEquals($login, $fan->getName()->getLogin());
        $this->assertEquals($firstName, $fan->getName()->getFirstName());
        $this->assertEquals($lastName, $fan->getName()->getLastName());
        $this->assertEquals($fatherName, $fan->getName()->getFatherName());
        $this->assertEquals(new DateTimeImmutable($birthday), $fan->getBirthday());
        $this->assertEquals($address, $fan->getAddress()->getAddress());
        $this->assertEquals($number, $fan->getPhone()->getNumber());
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
            new Name(
                $login = 'login',
                $firstName = 'firstName',
                $lastName = 'lastName',
                $fatherName = 'fatherName',
            ),
            new DateTimeImmutable($birthday = '1995-10-10'),
            new Address($address = 'Address'),
            new Phone($number = '+79889474747'),
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
            new Name(
                $login = 'login',
                $firstName = 'firstName',
                $lastName = 'lastName',
                $fatherName = 'fatherName',
            ),
            new DateTimeImmutable($birthday = '1995-10-10'),
            new Address($address = 'Address'),
            new Phone($number = '+79889474747'),
        );
    }

    public function testEmptyLogin(): void
    {
        $this->expectExceptionObject(
            new DomainException(
                'Логин не может быть пустым.'
            )
        );

        $fan = new Fan(
            $id = '283758da-fb37-43db-abb0-0a917fdaa527',
            $userId = 'a42546e0-31ad-4a94-b2f7-19c6e755218e',
            new Name(
                $login = '',
                $firstName = 'firstName',
                $lastName = 'lastName',
                $fatherName = 'fatherName',
            ),
            new DateTimeImmutable($birthday = '1995-10-10'),
            new Address($address = 'Address'),
            new Phone($number = '+79889474747'),
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
            new Name(
                $login = 'login',
                $firstName = '',
                $lastName = 'lastName',
                $fatherName = 'fatherName',
            ),
            new DateTimeImmutable($birthday = '1995-10-10'),
            new Address($address = 'Address'),
            new Phone($number = '+79889474747'),
        );
    }

    public function testEmptyAddress(): void
    {
        $this->expectExceptionObject(
            new DomainException(
                'Адрес не может быть пустым.'
            )
        );

        $fan = new Fan(
            $id = '283758da-fb37-43db-abb0-0a917fdaa527',
            $userId = 'a42546e0-31ad-4a94-b2f7-19c6e755218e',
            new Name(
                $login = 'login',
                $firstName = 'firstName',
                $lastName = 'lastName',
                $fatherName = 'fatherName',
            ),
            new DateTimeImmutable($birthday = '1995-10-10'),
            new Address($address = ''),
            new Phone($number = '+79889474747'),
        );
    }

    public function testEmptyNumber(): void
    {
        $this->expectExceptionObject(
            new DomainException(
                'Телефон не может быть пустым!'
            )
        );

        $fan = new Fan(
            $id = '283758da-fb37-43db-abb0-0a917fdaa527',
            $userId = 'a42546e0-31ad-4a94-b2f7-19c6e755218e',
            new Name(
                $login = 'login',
                $firstName = 'firstName',
                $lastName = 'lastName',
                $fatherName = 'fatherName',
            ),
            new DateTimeImmutable($birthday = '1995-10-10'),
            new Address($address = 'Address'),
            new Phone($number = ''),
        );
    }

    public function testIncorrectNumber(): void
    {
        $this->expectExceptionObject(
            new DomainException(
                'Телефон должен соответствовать формату +7NNNNNNNNNN'
            )
        );

        $fan = new Fan(
            $id = '283758da-fb37-43db-abb0-0a917fdaa527',
            $userId = 'a42546e0-31ad-4a94-b2f7-19c6e755218e',
            new Name(
                $login = 'login',
                $firstName = 'firstName',
                $lastName = 'lastName',
                $fatherName = 'fatherName',
            ),
            new DateTimeImmutable($birthday = '1995-10-10'),
            new Address($address = 'Address'),
            new Phone($number = '3453424345345'),
        );
    }

    public function validDataProvider(): array
    {
        return [
            'Все данные' => [
                'id' => '283758da-fb37-43db-abb0-0a917fdaa527',
                'userId' => 'a42546e0-31ad-4a94-b2f7-19c6e755218e',
                'login' => 'login',
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
                'login' => 'login',
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
                'login' => 'login',
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
