<?php

declare(strict_types=1);

namespace App\SharedKernel\Domain\Model;

use App\Util\EventDispatcher\Model\Event;

/**
 * Указыввает на то что наследуемый класс является агрегатом. Реализует отправку событий.
 */
abstract class Aggregate
{
    /** @var Event[] $events */
    private array $events = [];

    /**
     * @return array<Event>
     */
    public function dispatchEvents(): array
    {
        $events = $this->events;
        $this->events = [];

        return $events;
    }

    protected function recordEvent(Event $event): void
    {
        array_push($this->events, $event);
    }
}
