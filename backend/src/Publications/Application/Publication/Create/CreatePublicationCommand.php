<?php

declare(strict_types=1);

namespace App\Publications\Application\Publication\Create;

final class CreatePublicationCommand
{
    public function __construct(
        private string $authorId,
        private string $contentTitle,
        private string $contentText,
        private ?string $contentImageId,
    ) {
    }

    public function getAuthorId(): string
    {
        return $this->authorId;
    }

    public function getContentTitle(): string
    {
        return $this->contentTitle;
    }

    public function getContentText(): string
    {
        return $this->contentText;
    }

    public function getContentImageId(): ?string
    {
        return $this->contentImageId;
    }
}
