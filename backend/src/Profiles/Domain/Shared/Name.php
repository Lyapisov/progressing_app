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
     * @ORM\Column(name="first", type="string", nullable=false)
     */
    private string $first;

    /**
     * @ORM\Column(name="last", type="string", nullable=true)
     */
    private ?string $last;

    /**
     * @ORM\Column(name="father", type="string", nullable=true)
     */
    private ?string $father;

    public function __construct(
        string $first,
        ?string $last,
        ?string $father,
    ) {
        $this->setFirst($first);
        $this->last = $last;
        $this->father = $father;
    }

    public function getFirst(): string
    {
        return $this->first;
    }

    public function getLast(): ?string
    {
        return $this->last;
    }

    public function getFather(): ?string
    {
        return $this->father;
    }

    public function getFull(): string
    {
        $fullName = $this->last . ' ' . $this->first . ' ' . $this->father;

        return trim($fullName);
    }

    private function setFirst(string $firstName): void
    {
        Assert::notEmpty(
            $firstName,
            'Имя не может быть пустым.'
        );

        $this->first = $firstName;
    }
}
