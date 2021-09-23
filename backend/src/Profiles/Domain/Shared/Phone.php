<?php

declare(strict_types=1);

namespace App\Profiles\Domain\Shared;

use App\SharedKernel\Domain\Assert\Assert;
use App\SharedKernel\Infrastructure\Assert\Regex;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Embeddable()
 */
class Phone
{
    /**
     * @ORM\Column(name="number", type="string", nullable=false)
     */
    private string $number;

    public function __construct(string $number)
    {
        $this->setPhone($number);
    }

    public function getNumber(): string
    {
        return $this->number;
    }

    private function setPhone(string $number): void
    {
        Assert::notEmpty(
            $number,
            'Телефон не может быть пустым!'
        );

        Assert::regex(
            $number,
            '/' . Regex::PHONE_NUMBER . '/',
            'Телефон должен соответствовать формату +7NNNNNNNNNN'
        );

        $this->number = $number;
    }
}
