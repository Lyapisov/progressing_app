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
    private const PUBLISHED = 'published';
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

    public function publish(): void
    {
        if ($this->name !== self::DRAFT) {
            throw new \DomainException(
                'Публикация доступна только из статуса "Черновик".'
            );
        }

        $this->name = self::PUBLISHED;
    }

    public function archive(): void
    {
        if ($this->name !== self::DRAFT && $this->name !== self::PUBLISHED) {
            throw new \DomainException(
              'Архивация публикации доступна только из статуса "Черновик" или "Опубликована"'
            );
        }

        $this->name = self::ARCHIVED;
    }

    public function draft(): void
    {
        if ($this->name !== self::ARCHIVED && $this->name !== self::PUBLISHED) {
            throw new \DomainException(
                'Публикацию можно перевести в черновик только из статуса "Архивирована" или "Опубликована"'
            );
        }

        $this->name = self::ARCHIVED;
    }

    public function ban(): void
    {
        $this->name = self::BANNED;
    }

    public function getName(): string
    {
        return $this->name;
    }
}
