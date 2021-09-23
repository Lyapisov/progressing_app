<?php

declare(strict_types=1);

namespace App\Profiles\Domain\Musician;

use App\Profiles\Domain\Shared\Address;
use App\Profiles\Domain\Shared\Name;
use App\Profiles\Domain\Shared\Phone;
use App\SharedKernel\Domain\Model\Aggregate;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;

/**
 * Музыкант
 *
 * @ORM\Entity
 * @ORM\Table(name="musician_profiles")
 */
final class Musician extends Aggregate
{
    public function __construct(
        /**
         * @ORM\Column(name="id", type="string", nullable=false)
         * @ORM\Id
         */
        private string $id,
        /**
         * @ORM\Column(name="user_id", type="string", nullable=false)
         */
        private string $userId,
        /**
         * @ORM\Embedded(class="App\Profiles\Domain\Shared\Name")
         */
        private Name $name,
        /**
         * @ORM\Column(name="birthday", type="date_immutable", nullable=false)
         *
         * @var DateTimeImmutable
         */
        private DateTimeImmutable $birthday,
        /**
         * @ORM\Embedded(class="App\Profiles\Domain\Shared\Address")
         */
        private Address $address,
        /**
         * @ORM\Embedded(class="App\Profiles\Domain\Shared\Phone")
         */
        private Phone $phone,
        /**
         * @ORM\Column(name="favorite_musician_ids", type="simple_array")
         *
         * @var string[]
         */
        private array $favoriteMusicianIds
    ) {
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getUserId(): string
    {
        return $this->userId;
    }

    public function getName(): Name
    {
        return $this->name;
    }

    public function getBirthday(): DateTimeImmutable
    {
        return $this->birthday;
    }

    public function getAddress(): Address
    {
        return $this->address;
    }

    public function getPhone(): Phone
    {
        return $this->phone;
    }

    public function getFavoriteMusicianIds(): array
    {
        return $this->favoriteMusicianIds;
    }
}
