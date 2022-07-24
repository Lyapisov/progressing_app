<?php

declare(strict_types=1);

namespace App\SharedKernel\Infrastructure\EventListeners\UserAccess;

use App\UserAccess\Domain\UserCreated;

final class CreatedListener
{
    public function __construct()
    {
    }

    public function onEventMessages(UserCreated $event): void
    {
    }
}
