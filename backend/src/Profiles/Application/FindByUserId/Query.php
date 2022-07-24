<?php

declare(strict_types=1);

namespace App\Profiles\Application\FindByUserId;

final class Query
{
    public function __construct(
        private string $userId
    ) {
    }

    /**
     * @return string
     */
    public function getUserId(): string
    {
        return $this->userId;
    }
}
