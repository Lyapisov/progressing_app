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
     * @param array<int, string> $authors
     */
    public function __construct(
        array $authors
    ) {
        $jsonAuthors = json_encode($authors);
        if (!$jsonAuthors) {
            $jsonAuthors = '{}';
        }

        $this->authors = $jsonAuthors;
    }

    public static function createEmpty(): Likes
    {
        $likes = new self([]);

        return $likes;
    }

    public function getAuthors(): string
    {
        return $this->authors;
    }

    public function getCount(): int
    {
        $arrayAuthors = json_decode($this->authors);
        $lastKey = array_key_last($arrayAuthors);
        if (is_null($lastKey)) {
            return 0;
        }

        return $lastKey + 1;
    }
}
