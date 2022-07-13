<?php

declare(strict_types=1);

namespace App\UserAccess\Test\Domain;

use App\UserAccess\Domain\Role;
use App\UserAccess\Domain\User;
use App\UserAccess\Domain\UserCreated;
use App\Util\PasswordOperator\HashPasswordOperator;
use DateTimeImmutable;
use DomainException;
use PHPUnit\Framework\TestCase;

final class ConstructorTest extends TestCase
{
    public function testSuccess(): void
    {
        $user = new User(
            $id = 'da4dd4a5-6a9d-40c2-9f5a-7afb26cd16a0',
            $login = 'dimua',
            $email = 'dimua@gmail.com',
            $password = 'qwerty12345678',
            $registrationDate = new DateTimeImmutable('2021-01-01'),
            $passwordOperator = new HashPasswordOperator(),
        );

        $this->assertEquals($id, $user->getId());
        $this->assertEquals($login, $user->getLogin());
        $this->assertEquals($email, $user->getEmail());
        $this->assertTrue($passwordOperator->checkPassword($password, $user->getPassword()));
        $this->assertEquals($registrationDate, $user->getRegistrationDate());
    }

    public function testSuccessWithCorrectedEmail(): void
    {
        $user = new User(
            $id = 'da4dd4a5-6a9d-40c2-9f5a-7afb26cd16a0',
            $login = 'dimua',
            $email = 'diMua@gmail.com',
            $password = 'qwerty12345678',
            $registrationDate = new DateTimeImmutable('2021-01-01'),
            $passwordOperator = new HashPasswordOperator(),
        );

        $this->assertEquals($id, $user->getId());
        $this->assertEquals($login, $user->getLogin());
        $this->assertEquals('dimua@gmail.com', $user->getEmail());
        $this->assertTrue($passwordOperator->checkPassword($password, $user->getPassword()));
        $this->assertEquals($registrationDate, $user->getRegistrationDate());

        $events = $user->dispatchEventMessages();
        /** @var UserCreated $userCreated */
        $userCreated = $events[0];

        $this->assertInstanceOf(UserCreated::class, $userCreated);
        $this->assertEquals($id, $user->getId());
    }

    public function testWithoutId(): void
    {
        $this->expectExceptionObject(
            new DomainException(
                "Идентификатор пользователя должен соответствовать формату uuid."
            )
        );

        $user = new User(
            $id = '',
            $login = 'dimua',
            $email = 'dimua@gmail.com',
            $password = 'qwerty12345678',
            $registrationDate = new DateTimeImmutable('2021-01-01'),
            $passwordOperator = new HashPasswordOperator(),
        );
    }

    public function testWithoutLogin(): void
    {
        $this->expectExceptionObject(
            new DomainException(
                "Логин пользователя не может быть пустым."
            )
        );

        $user = new User(
            $id = 'da4dd4a5-6a9d-40c2-9f5a-7afb26cd16a0',
            $login = '',
            $email = 'dimua@gmail.com',
            $password = 'qwerty12345678',
            $registrationDate = new \DateTimeImmutable('2021-01-01'),
            $passwordOperator = new HashPasswordOperator(),
        );
    }

    public function testWithoutEmail(): void
    {
        $this->expectExceptionObject(
            new DomainException(
                "Электронная почта должна быть верного формата."
            )
        );

        $user = new User(
            $id = 'da4dd4a5-6a9d-40c2-9f5a-7afb26cd16a0',
            $login = 'dimua',
            $email = '',
            $password = 'qwerty12345678',
            $registrationDate = new \DateTimeImmutable('2021-01-01'),
            $passwordOperator = new HashPasswordOperator(),
        );
    }

    public function testWithIncorrectEmail(): void
    {
        $this->expectExceptionObject(
            new DomainException(
                "Электронная почта должна быть верного формата."
            )
        );

        $user = new User(
            $id = 'da4dd4a5-6a9d-40c2-9f5a-7afb26cd16a0',
            $login = 'dimua',
            $email = 'dimuagmail.com',
            $password = 'qwerty12345678',
            $registrationDate = new \DateTimeImmutable('2021-01-01'),
            $passwordOperator = new HashPasswordOperator(),
        );
    }

    public function testWithoutPassword(): void
    {
        $this->expectExceptionObject(
            new DomainException(
                "Пароль не может быть пустым значением."
            )
        );

        $user = new User(
            $id = 'da4dd4a5-6a9d-40c2-9f5a-7afb26cd16a0',
            $login = 'dimua',
            $email = 'dimua@gmail.com',
            $password = '',
            $registrationDate = new \DateTimeImmutable('2021-01-01'),
            $passwordOperator = new HashPasswordOperator(),
        );
    }

    public function testWithLowPassword(): void
    {
        $this->expectExceptionObject(
            new DomainException(
                "Пароль должен содержать более 4 символов."
            )
        );

        $user = new User(
            $id = 'da4dd4a5-6a9d-40c2-9f5a-7afb26cd16a0',
            $login = 'dimua',
            $email = 'dimua@gmail.com',
            $password = 'qwe',
            $registrationDate = new \DateTimeImmutable('2021-01-01'),
            $passwordOperator = new HashPasswordOperator(),
        );
    }
}
