<?php

declare(strict_types=1);

namespace App\Profiles\Domain\Shared;

use App\SharedKernel\Domain\Assert\Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Embeddable()
 */
class Name
{
    /**
     * @ORM\Column(name="login", type="string", nullable=false)
     */
    private string $login;

    /**
     * @ORM\Column(name="first_name", type="string", nullable=false)
     */
    private string $firstName;

    /**
     * @ORM\Column(name="last_name", type="string", nullable=true)
     */
    private ?string $lastName;

    /**
     * @ORM\Column(name="father_name", type="string", nullable=true)
     */
    private ?string $fatherName;

    public function __construct(
        string $login,
        string $firstName,
        ?string $lastName,
        ?string $fatherName,
    )
    {
        $this->setLogin($login);
        $this->setFirstName($firstName);
        $this->lastName = $lastName;
        $this->fatherName = $fatherName;
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

    private function setLogin(string $login): void
    {
        Assert::notEmpty(
            $login,
            'Логин не может быть пустым.'
        );

        $this->login = $login;
    }

    private function setFirstName(string $firstName): void
    {
        Assert::notEmpty(
            $firstName,
            'Имя не может быть пустым.'
        );

        $this->firstName = $firstName;
    }
}
