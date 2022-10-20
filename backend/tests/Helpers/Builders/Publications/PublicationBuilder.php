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
    /** @var string[] $likesAuthors */
    private array $likesAuthors;
    private bool $isPublishedStatus = false;
    private bool $isArchivedStatus = false;
    private bool $isBannedStatus = false;
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

    /**
     * @param string[] $likesAuthors
     * @return $this
     */
    public function withLikesAuthors(array $likesAuthors): PublicationBuilder
    {
        $this->likesAuthors = $likesAuthors;
        return $this;
    }

    public function withCreatedAt(DateTimeImmutable $createdAt): PublicationBuilder
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    public function withPublishedStatus(): PublicationBuilder
    {
        $this->isPublishedStatus = true;
        return $this;
    }

    public function withArchivedStatus(): PublicationBuilder
    {
        $this->isArchivedStatus = true;
        return $this;
    }

    public function withBannedStatus(): PublicationBuilder
    {
        $this->isBannedStatus = true;
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

        if ($this->isPublishedStatus) {
            $publication->publish();
        }

        if ($this->isArchivedStatus) {
            $publication->archive();
        }

        if (!empty($this->likesAuthors)) {
            foreach ($this->likesAuthors as $key => $authorId) {
                $publication->like($authorId);
            }
        }

        return $publication;
    }
}
