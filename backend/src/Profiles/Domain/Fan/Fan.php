<?php

declare(strict_types=1);

namespace App\Profiles\Domain\Fan;

use App\Profiles\Domain\Shared\Address;
use App\Profiles\Domain\Shared\Name;
use App\Profiles\Domain\Shared\Phone;
use App\SharedKernel\Domain\Assert\Assert;
use App\SharedKernel\Domain\Model\Aggregate;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;

/**
 * Фанат
 *
 * @ORM\Entity
 * @ORM\Table(name="fan_profiles")
 */
class Fan extends Aggregate
{
    /**
     * @ORM\Column(name="id", type="string", nullable=false)
     * @ORM\Id
     */
    private string $id;
    /**
     * @ORM\Column(name="user_id", type="string", nullable=false)
     */
    private string $userId;
    /**
     * @ORM\Embedded(class="App\Profiles\Domain\Shared\Name")
     */
    private Name $name;
    /**
     * @ORM\Column(name="birthday", type="date_immutable", nullable=false)
     *
     * @var DateTimeImmutable
     */
    private DateTimeImmutable $birthday;
    /**
     * @ORM\Embedded(class="App\Profiles\Domain\Shared\Address")
     */
    private Address $address;
    /**
     * @ORM\Embedded(class="App\Profiles\Domain\Shared\Phone")
     */
    private Phone $phone;
    /**
     * @ORM\Column(name="favorite_musician_ids", type="simple_array")
     *
     * @var string[]
     */
    private array $favoriteMusicianIds = [''];

    public function __construct(
        string $id,
        string $userId,
        Name $name,
        DateTimeImmutable $birthday,
        Address $address,
        Phone $phone,
    ) {
        $this->setId($id);
        $this->setUserId($userId);
        $this->name = $name;
        $this->birthday = $birthday;
        $this->address = $address;
        $this->phone = $phone;
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

    public function getFavoriteMusicians(): array
    {
        return $this->favoriteMusicianIds;
    }

    private function setId(string $id): void
    {
        Assert::uuid(
            $id,
            'Идентификатор фаната должен соответствовать формату uuid.'
        );

        $this->id = $id;
    }

    private function setUserId(string $userId): void
    {
        Assert::uuid(
            $userId,
            'Идентификатор пользователя должен соответствовать формату uuid.'
        );

        $this->userId = $userId;
    }
}
