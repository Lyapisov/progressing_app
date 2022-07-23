<?php

declare(strict_types=1);

namespace App\Profiles\Domain\Shared;

use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;

/**
 * Персональные данные профиля
 *
 * @ORM\Embeddable()
 */
class PersonalData
{
    /**
     * @ORM\Embedded(class="App\Profiles\Domain\Shared\Name")
     */
    private Name $name;

    /**
     * @ORM\Embedded(class="App\Profiles\Domain\Shared\Phone")
     */
    private Phone $phone;

    /**
     * @ORM\Embedded(class="App\Profiles\Domain\Shared\Address")
     */
    private Address $address;

    /**
     * @ORM\Column(name="birthday", type="date_immutable", nullable=false)
     *
     * @var DateTimeImmutable
     */
    private DateTimeImmutable $birthday;

    public function __construct(
        Name $name,
        Phone $phone,
        Address $address,
        DateTimeImmutable $birthday
    ) {
        $this->name = $name;
        $this->phone = $phone;
        $this->address = $address;
        $this->birthday = $birthday;
    }

    public function getName(): Name
    {
        return $this->name;
    }

    public function getPhone(): Phone
    {
        return $this->phone;
    }

    public function getAddress(): Address
    {
        return $this->address;
    }

    public function getBirthday(): DateTimeImmutable
    {
        return $this->birthday;
    }
}
