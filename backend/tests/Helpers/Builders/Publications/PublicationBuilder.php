<?php

declare(strict_types=1);

namespace App\Tests\Helpers\Builders\Publications;

use App\Publications\Domain\Publication\Content;
use App\Publications\Domain\Publication\Image;
use App\Publications\Domain\Publication\Likes;
use App\Publications\Domain\Publication\Publication;
use App\Publications\Domain\Publication\Status;
use DateTimeImmutable;

final class PublicationBuilder
{
    private const ID = '54fb9344-428f-449f-8380-b97fa9a59ac2';
    private const AUTHOR_ID = '54fb9344-428f-449f-8380-b97fa9a59ac3';

    private string $id = self::ID;
    private string $authorId = self::AUTHOR_ID;
    private Content $content;
    private Likes $likes;
    private Status $status;
    private DateTimeImmutable $createdAt;

    public function __construct()
    {
        $this->content = new Content(
            'title',
            'text',
            Image::createDefault(),
        );
        $this->likes = Likes::createEmpty();
        $this->status = new Status();
        $this->createdAt = new DateTimeImmutable();
    }

    public function withId(string $id): PublicationBuilder
    {
        $this->id = $id;
        return $this;
    }

    public function withAuthorId(string $authorId): PublicationBuilder
    {
        $this->authorId = $authorId;
        return $this;
    }

    public function withContent(Content $content): PublicationBuilder
    {
        $this->content = $content;
        return $this;
    }

    public function withLikes(Likes $likes): PublicationBuilder
    {
        $this->likes = $likes;
        return $this;
    }

    public function withCreatedAt(DateTimeImmutable $createdAt): PublicationBuilder
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    public function build(): Publication
    {
        $publication = new Publication(
            $this->id,
            $this->authorId,
            $this->content,
            $this->likes,
            $this->createdAt,
        );

        return $publication;
    }
}
