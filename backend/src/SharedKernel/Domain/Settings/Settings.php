<?php

declare(strict_types=1);

namespace App\SharedKernel\Domain\Settings;

final class Settings
{
    public function getAuthCodeInterval(): string
    {
        return 'PT1M';
    }

    public function getAccessTokenInterval(): string
    {
        return 'PT10M';
    }

    public function getRefreshTokenInterval(): string
    {
        return 'P7D';
    }
}
