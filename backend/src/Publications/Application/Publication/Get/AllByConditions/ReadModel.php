<?php

declare(strict_types=1);

namespace App\Publications\Application\Publication\Get\AllByConditions;

use DateTimeImmutable;

final class ReadModel
{
    /**
     * @param string $id
     * @param string $status
     * @param string $contextTitle
     * @param string $contentText
     * @param string $contentImageId
     * @param string $authorId
     * @param string $authorFullName
     * @param string $authorRole
     * @param int $likesCount
     * @param string[] $likesAuthors
     * @param DateTimeImmutable $createdAt
     */
    public function __construct(
        private string $id,
        private string $status,
        private string $contextTitle,
        private string $contentText,
        private string $contentImageId,
        private string $authorId,
        private string $authorFullName,
        private string $authorRole,
        private int $likesCount,
        private array $likesAuthors,
        private DateTimeImmutable $createdAt,
    ) {
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * @return string
     */
    public function getContextTitle(): string
    {
        return $this->contextTitle;
    }

    /**
     * @return string
     */
    public function getContentText(): string
    {
        return $this->contentText;
    }

    /**
     * @return string
     */
    public function getContentImageId(): string
    {
        return $this->contentImageId;
    }

    /**
     * @return string
     */
    public function getAuthorId(): string
    {
        return $this->authorId;
    }

    /**
     * @return string
     */
    public function getAuthorFullName(): string
    {
        return $this->authorFullName;
    }

    /**
     * @return string
     */
    public function getAuthorRole(): string
    {
        return $this->authorRole;
    }

    /**
     * @return int
     */
    public function getLikesCount(): int
    {
        return $this->likesCount;
    }

    /**
     * @return string[]
     */
    public function getLikesAuthors(): array
    {
        return $this->likesAuthors;
    }

    /**
     * @return DateTimeImmutable
     */
    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }
}
