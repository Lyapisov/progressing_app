<?php

declare(strict_types=1);

namespace App\Publications\Domain\Author;

use Doctrine\ORM\Mapping as ORM;

/**
 * Роль автора публикации
 *
 * @ORM\Embeddable()
 */
class Role
{
    private const FAN = 'fan';
    private const MUSICIAN = 'musician';
    private const PRODUCER = 'producer';

    /**
     * @ORM\Column(type="string", name="name", nullable=false)
     */
    private string $name;

    public static function fan(): Role
    {
        $role = new Role();
        $role->name = self::FAN;

        return $role;
    }

    public static function musician(): Role
    {
        $role = new Role();
        $role->name = self::MUSICIAN;

        return $role;
    }

    public static function producer(): Role
    {
        $role = new Role();
        $role->name = self::PRODUCER;

        return $role;
    }

    public function isFan(): bool
    {
        return $this->name === self::FAN;
    }

    public function isMusician(): bool
    {
        return $this->name === self::MUSICIAN;
    }

    public function isProducer(): bool
    {
        return $this->name === self::PRODUCER;
    }

    public function getName(): string
    {
        return $this->name;
    }
}
