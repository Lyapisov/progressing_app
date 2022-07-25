<?php

namespace App\Util\EventDispatcher;

interface EventDispatcher
{
    /**
     * @param array<object> $events
     */
    public function dispatch(array $events): void;

    public function addEventListener(string $eventName, callable $listener): void;
}
