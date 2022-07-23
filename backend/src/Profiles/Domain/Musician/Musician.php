<?php

declare(strict_types=1);

namespace App\Profiles\Domain\Musician;

use App\Profiles\Domain\Shared\PersonalData;
use App\SharedKernel\Domain\Model\Aggregate;
use Doctrine\ORM\Mapping as ORM;

/**
 * Музыкант
 *
 * @ORM\Entity
 * @ORM\Table(name="profiles_musician")
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
         * @ORM\Embedded(class="App\Profiles\Domain\Shared\PersonalData")
         */
        private PersonalData $personalData,
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

    public function getPersonalData(): PersonalData
    {
        return $this->personalData;
    }
}
