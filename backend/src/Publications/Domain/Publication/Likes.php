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
        $this->setAuthors($authors);
        $this->setCount($authors);
    }

    public function process(string $authorId): void
    {
        $authorFound = false;
        $likesAuthors = $this->getAuthors();
        foreach ($likesAuthors as $key => $author) {
            if ($author === $authorId) {
                $authorFound = true;
                unset($likesAuthors[$key]);
                $this->setAuthors($likesAuthors);
                $this->setCount($likesAuthors);
                break;
            }
        }

        if (!$authorFound) {
            $likesAuthors[] = $authorId;
            $this->setAuthors($likesAuthors);
            $this->setCount($likesAuthors);
        }
    }

    public static function createEmpty(): Likes
    {
        return new self();
    }

    /**
     * @return String[]
     */
    public function getAuthors(): array
    {
        $jsonAuthors = $this->authors;

        return json_decode($jsonAuthors, true);
    }

    public function getCount(): int
    {
        return $this->count;
    }

    /**
     * @param array<int, string> $authors
     */
    private function setAuthors(array $authors): void
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
