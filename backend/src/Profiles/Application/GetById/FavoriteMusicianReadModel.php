<?php

declare(strict_types=1);

namespace App\Profiles\Application\GetById;

final class FavoriteMusicianReadModel
{

    public function __construct(
        private string $id
    )
    {
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }
}
