<?php

declare(strict_types=1);

namespace App\Profiles\Application\GetById;


final class ReadModel
{
    public function __construct(
        private string $fanId,
        private string $name,
        /** @var FavoriteMusicianReadModel[] $favoriteMusicians */
        private array $favoriteMusicians
    )
    {
    }

    /**
     * @return string
     */
    public function getFanId(): string
    {
        return $this->fanId;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return FavoriteMusicianReadModel[]
     */
    public function getFavoriteMusicians(): array
    {
        return $this->favoriteMusicians;
    }
}
