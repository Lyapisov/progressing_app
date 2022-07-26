<?php

declare(strict_types=1);

namespace App\Profiles\Domain\Events;

use App\Util\EventDispatcher\Model\Event;

final class MusicianCreated extends Event
{
    public function __construct(
        private string $id,
    ) {
    }

    public function getId(): string
    {
        return $this->id;
    }
}
