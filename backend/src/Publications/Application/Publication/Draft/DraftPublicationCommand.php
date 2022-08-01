<?php

namespace App\Publications\Application\Publication\Draft;

class DraftPublicationCommand
{
    public function __construct(
        private string $id,
    ) {
    }

    public function getId(): string
    {
        return $this->id;
    }
}
