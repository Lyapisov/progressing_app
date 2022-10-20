<?php

declare(strict_types=1);

namespace App\Api\Controller\Http\Publication\GetList;

use App\Util\HttpRequest\AbstractRequest;

final class GetListRequest extends AbstractRequest
{
    /**
     * @return String[]
     */
    public function getAuthorsFilter(): array
    {
        $filters = $this->getFilters();

        if (is_null($filters)) {
            return [];
        }

        return $filters['authors'] ?? [];
    }

    /**
     * @return String[]
     */
    public function getStatusesFilter(): array
    {
        $filters = $this->getFilters();

        if (is_null($filters)) {
            return [];
        }

        return $filters['statuses'] ?? [];
    }

    public function getCreatedAtSorting(): ?string
    {
        $sorting = $this->getSorting();

        if (is_null($sorting)) {
            return null;
        }

        return $sorting['createdAt'] ?? null;
    }

    /**
     * @return array<string,mixed>|null
     */
    private function getFilters(): ?array
    {
        return $this->validatedData['filters'] ?? null;
    }

    /**
     * @return array<string,mixed>|null
     */
    private function getSorting(): ?array
    {
        return $this->validatedData['sorting'] ?? null;
    }

    protected function getRules(): array
    {
        return [
            'filters' => 'array',
            'filters.authors' => 'nullable|array',
            'filters.statuses' => 'nullable|array',
            'sorting' => 'array',
            'sorting.createdAt' => 'nullable|in:ASC,DESC',
        ];
    }

    protected function getMessages(): array
    {
        return [
            'filters:array' => 'Параметры фильтрации неверного формата.',
            'filters.authors:array' => 'Параметр фильтрации "authors" неверного формата.',
            'filters.statuses:array' => 'Параметр фильтрации "statuses" неверного формата.',
            'sorting:array' => 'Параметры сортировки неверного формата.',
            'sorting.createdAt:in' => 'Параметр сортировки "createdAt" неверного формата.',
        ];
    }
}
