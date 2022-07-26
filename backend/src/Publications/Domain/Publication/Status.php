<?php

declare(strict_types=1);

namespace App\Publications\Domain\Publication;

use Doctrine\ORM\Mapping as ORM;

/**
 * Статус публикации
 *
 * @ORM\Embeddable()
 */
class Status
{
    private const DRAFT = 'draft';
    private const ACTIVE = 'active';
    private const ARCHIVED = 'archived';
    private const BANNED = 'banned';

    /**
     * @ORM\Column(type="string", name="name", nullable=false)
     */
    private string $name;

    public function __construct()
    {
        $this->name = self::DRAFT;
    }

    public function getName(): string
    {
        return $this->name;
    }
}
