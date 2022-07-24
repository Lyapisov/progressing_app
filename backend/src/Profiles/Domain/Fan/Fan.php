<?php

declare(strict_types=1);

namespace App\Profiles\Domain\Fan;

use App\Profiles\Domain\Shared\PersonalData;
use App\SharedKernel\Domain\Assert\Assert;
use App\SharedKernel\Domain\Model\Aggregate;
use Doctrine\ORM\Mapping as ORM;

/**
 * Фанат
 *
 * @ORM\Entity
 * @ORM\Table(name="profiles_fan")
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
     * @ORM\Embedded(class="App\Profiles\Domain\Shared\PersonalData")
     */
    private PersonalData $personalData;

    public function __construct(
        string $id,
        string $userId,
        PersonalData $personalData,
    ) {
        $this->setId($id);
        $this->setUserId($userId);
        $this->personalData = $personalData;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getUserId(): string
    {
        return $this->userId;
    }

    public function getPersonalData(): PersonalData
    {
        return $this->personalData;
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
