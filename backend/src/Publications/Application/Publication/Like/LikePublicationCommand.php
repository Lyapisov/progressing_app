<?php

namespace App\Publications\Application\Publication\Like;

class LikePublicationCommand
{
    public function __construct(
        private string $publicationId,
        private string $likeAuthorId,
    ) {
    }

    /**
     * @return string
     */
    public function getPublicationId(): string
    {
        return $this->publicationId;
    }

    /**
     * @return string
     */
    public function getLikeAuthorId(): string
    {
        return $this->likeAuthorId;
    }
}
