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
        string $firstName,
        ?string $lastName,
        ?string $fatherName,
    )
    {
        $this->setFirstName($firstName);
        $this->lastName = $lastName;
        $this->fatherName = $fatherName;
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

    private function setFirstName(string $firstName): void
    {
        Assert::notEmpty(
            $firstName,
            'Имя не может быть пустым.'
        );

        $this->firstName = $firstName;
    }
}
