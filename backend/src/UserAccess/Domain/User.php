<?php

declare(strict_types=1);

namespace App\UserAccess\Domain;

use App\SharedKernel\Domain\Assert\Assert;
use App\SharedKernel\Domain\Model\Aggregate;
use App\UserAccess\Domain\Events\UserCreated;
use App\Util\PasswordOperator\PasswordOperator;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
use DomainException;

/**
 * Пользователь системы
 *
 * @ORM\Entity
 * @ORM\Table(name="users")
 */
class User extends Aggregate
{
    /**
     * Идентификатор
     *
     * @ORM\Column(name="id", type="string")
     * @ORM\Id()
     *
     * @var string
     */
    private string $id;

    /**
     * Логин
     *
     * @ORM\Column(name="login", type="string", unique=true)
     *
     * @var string
     */
    private string $login;

    /**
     * Электронная почта
     *
     * @ORM\Column(name="email", type="string", unique=true)
     *
     * @var string
     */
    private string $email;

    /**
     * Пароль для входа
     *
     * @ORM\Column(name="password", type="string")
     *
     * @var string
     */
    private string $password = '';

    /**
     * Дата регистрации пользователя
     *
     * @ORM\Column(name="registration_date", type="datetime_immutable")
     *
     * @var DateTimeImmutable
     */
    private DateTimeImmutable $registrationDate;

    public function __construct(
        string $id,
        string $login,
        string $email,
        string $password,
        DateTimeImmutable $registrationDate,
        PasswordOperator $passwordOperator,
    ) {
        $this->setId($id);
        $this->setLogin($login);
        $this->setEmail($email);
        $this->setPassword($password, $passwordOperator);
        $this->registrationDate = $registrationDate;

        $this->recordEvent(new UserCreated($this->id));
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
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
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @return DateTimeImmutable
     */
    public function getRegistrationDate(): DateTimeImmutable
    {
        return $this->registrationDate;
    }

    private function setId(string $id): void
    {
        Assert::uuid(
            $id,
            'Идентификатор пользователя должен соответствовать формату uuid.'
        );

        $this->id = $id;
    }

    private function setLogin(string $login): void
    {
        Assert::notEmpty(
            $login,
            'Логин пользователя не может быть пустым.'
        );

        $this->login = $login;
    }

    private function setEmail(string $email): void
    {
        $email = (string) mb_strtolower($email);

        Assert::email(
            $email,
            'Электронная почта должна быть верного формата.'
        );

        $this->email = $email;
    }

    private function setPassword(string $password, PasswordOperator $passwordOperator): void
    {
        if ($this->password) {
            throw new DomainException('Пароль уже установлен.');
        }

        Assert::notEmpty(
            $password,
            'Пароль не может быть пустым значением.'
        );

        if (iconv_strlen($password) < 4) {
            throw new DomainException('Пароль должен содержать более 4 символов.');
        }

        $encryptedPassword = $passwordOperator->encryptPassword($password);

        $this->password = $encryptedPassword;
    }
}
