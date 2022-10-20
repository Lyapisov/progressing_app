<?php

declare(strict_types=1);

namespace App\Publications\Application\Publication\Get\AllByConditions\Query;

final class GetPublicationsByConditionsQuery
{
    public function __construct(
        private Filters $filters,
        private Sorting $sorting,
    ) {
    }

    public function getFilters(): Filters
    {
        return $this->filters;
    }

    public function getSorting(): Sorting
    {
        return $this->sorting;
    }
}
