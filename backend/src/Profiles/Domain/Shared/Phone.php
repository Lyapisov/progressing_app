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
     * @ORM\Column(name="number", type="string", nullable=true)
     */
    private ?string $number;

    public function __construct(?string $number)
    {
        $this->setNumber($number);
    }

    public function getNumber(): string
    {
        return $this->number;
    }

    private function setNumber(?string $number): void
    {
        if (!empty($number)) {
            Assert::regex(
                $number,
                '/' . Regex::PHONE_NUMBER . '/',
                'Номер телефона должен соответствовать формату +7NNNNNNNNNN'
            );
        }

        $this->number = $number;
    }
}
