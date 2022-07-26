<?php

declare(strict_types=1);

namespace App\Util\DateProvider;

use DateTimeImmutable;

final class DateProviderImpl implements DateProvider
{
    public function getNow(): DateTimeImmutable
    {
        return new DateTimeImmutable();
    }
}
