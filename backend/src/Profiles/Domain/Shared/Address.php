<?php

declare(strict_types=1);

namespace App\Profiles\Domain\Shared;

use App\SharedKernel\Domain\Assert\Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Embeddable()
 */
class Address
{
    /**
     * @ORM\Column(name="address", type="string", nullable=true)
     */
    private ?string $address;

    public function __construct(?string $address)
    {
        $this->setAddress($address);
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    private function setAddress(?string $address): void
    {
        $this->address = $address;
    }
}
