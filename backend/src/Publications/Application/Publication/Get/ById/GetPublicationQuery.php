<?php

namespace App\Publications\Application\Publication\Get\ById;

class GetPublicationQuery
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