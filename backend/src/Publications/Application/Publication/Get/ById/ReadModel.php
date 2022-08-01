<?php

namespace App\Publications\Application\Publication\Get\ById;

use DateTimeImmutable;

class ReadModel
{
    public function __construct(
        private string $id,
        private string $authorId,
        private string $contentTitle,
        private string $contentText,
        private string $contentImageId,
        private int $likesCount,
        private string $status,
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
    public function getAuthorId(): string
    {
        return $this->authorId;
    }

    /**
     * @return string
     */
    public function getContentTitle(): string
    {
        return $this->contentTitle;
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
     * @return int
     */
    public function getLikesCount(): int
    {
        return $this->likesCount;
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * @return DateTimeImmutable
     */
    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }
}
