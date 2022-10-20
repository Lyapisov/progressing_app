<?php

declare(strict_types=1);

namespace App\Publications\Application\Publication\Get\AllByConditions\Query;

final class Filters
{
    /**
     * @param String[] $authors
     * @param String[] $statuses
     */
    public function __construct(
        private array $authors,
        private array $statuses,
    ) {
    }

    /**
     * @return String[]
     */
    public function getAuthors(): array
    {
        return $this->authors;
    }

    /**
     * @return String[]
     */
    public function getStatuses(): array
    {
        return $this->statuses;
    }
}
