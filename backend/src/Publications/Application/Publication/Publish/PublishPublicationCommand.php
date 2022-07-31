<?php

namespace App\Publications\Application\Publication\Publish;

class PublishPublicationCommand
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