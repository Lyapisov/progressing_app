<?php

declare(strict_types=1);

namespace App\UserAccess\UseCase\SignUp;

use Symfony\Component\Validator\Constraints as Assert;

final class SignUpCommand
{
    /**
     * @Assert\Regex(
     *     pattern="/^[a-zа-яё_-]+$/i",
     *     match=true,
     *     message="Невозможно создать логин с данными символами."
     * )
     * @Assert\Length(
     *      min = 3,
     *      max = 30,
     *      minMessage = "Логин должен быть как минимум из {{ limit }} символов",
     *      maxMessage = "Логин не должен быть длиннее {{ limit }} символов"
     * )
     * @Assert\NotBlank(message="Логин не может быть пустым.")
     * @var string
     */
    private string $login;
    /**
     * @Assert\Email(message="Указана некорректная электронная почта.")
     * @Assert\NotBlank(message="Электронная почта не может быть пустой.")
     * @var string
     */
    private string $email;
    /**
     * @Assert\NotBlank(message="Пароль не может быть пустым.")
     * @var string
     */
    private string $password;
    /**
     * @Assert\NotBlank(message="Роль не может быть пустой.")
     * @var string
     */
    private string $role;

    /**
     * @param string $login
     * @param string $email
     * @param string $password
     * @param string $role
     */
    public function __construct(
        string $login,
        string $email,
        string $password,
        string $role
    ) {
        $this->login = $login;
        $this->email = $email;
        $this->password = $password;
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
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @return string
     */
    public function getRole(): string
    {
        return $this->role;
    }
}
