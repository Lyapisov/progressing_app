<?php

declare(strict_types=1);

namespace App\SharedKernel\Application\EventHandlers\UserAccess;

use App\UserAccess\Domain\Events\UserCreated;

final class CreatedHandler
{
    public function __construct()
    {
    }

    public function onEventMessages(UserCreated $event): void
    {
    }
}
