<?php

declare(strict_types=1);

namespace App\Util\DateProvider;

use DateTimeImmutable;

final class TestDateProvider implements DateProvider
{
    private DateTimeImmutable $now;

    public function setNow(DateTimeImmutable $date): void
    {
        $this->now = $date;
    }

    public function getNow(): DateTimeImmutable
    {
        return $this->now;
    }
}
