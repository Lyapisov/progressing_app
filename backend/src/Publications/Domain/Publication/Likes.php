<?php

declare(strict_types=1);

namespace App\Publications\Domain\Publication;

use Doctrine\ORM\Mapping as ORM;

/**
 * Лайки публикации
 *
 * @ORM\Embeddable()
 */
class Likes
{
    /**
     * Идентификаторы авторов лайков
     *
     * @ORM\Column(type="json", name="authors", nullable=false)
     */
    private string $authors;

    /**
     * Количество лайков
     *
     * @ORM\Column(type="integer", name="count", nullable=false)
     */
    private int $count;

    /**
     */
    private function __construct()
    {
        $authors = [];
        $this->setAuthor($authors);
        $this->setCount($authors);
    }

    public static function createEmpty(): Likes
    {
        return new self();
    }

    public function getAuthors(): string
    {
        return $this->authors;
    }

    public function getCount(): int
    {
        return $this->count;
    }

    /**
     * @param array<int, string> $authors
     */
    private function setAuthor(array $authors): void
    {
        $jsonAuthors = json_encode($authors);
        if (!$jsonAuthors) {
            $jsonAuthors = '{}';
        }

        $this->authors = $jsonAuthors;
    }

    /**
     * @param array<int, string> $authors
     */
    private function setCount(array $authors): void
    {
        $lastKey = array_key_last($authors);
        if (is_null($lastKey)) {
            $this->count = 0;
        }

        if (!is_null($lastKey)) {
            $this->count = (int)$lastKey + 1;
        }
    }
}
