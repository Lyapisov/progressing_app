<?php

declare(strict_types=1);

namespace App\Profiles\Application\Producer\Get\ById;

final class GetProducerByIdQuery
{
    public function __construct(
        private string $id
    ) {
    }

    public function getId(): string
    {
        return $this->id;
    }
}
