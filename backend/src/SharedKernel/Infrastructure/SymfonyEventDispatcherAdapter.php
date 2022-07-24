<?php

declare(strict_types=1);

namespace App\SharedKernel\Infrastructure;

use App\SharedKernel\Application\Service\EventDispatcher;
use Symfony\Component\EventDispatcher\EventDispatcherInterface as SymfonyEventDispatcher;

final class SymfonyEventDispatcherAdapter implements EventDispatcher
{
    public function __construct(
        private SymfonyEventDispatcher $symfonyEventDispatcher
    ) {
    }

    public function dispatch(array $events): void
    {
        foreach ($events as $event) {
            $this->dispatchEvent($event);
        }
    }

    public function addEventListener(string $eventName, callable $listener): void
    {
        $this->symfonyEventDispatcher->addListener($eventName, $listener);
    }

    /**
     * Отправить событие на обработку всем слушателям.
     *
     * @param object $event
     */
    private function dispatchEvent(object $event): void
    {
        $eventName = $this->extractEventName($event);

        $listeners = $this
            ->symfonyEventDispatcher
            ->getListeners($eventName);

        foreach ($listeners as $listener) {
            \call_user_func($listener, $event);
        }
    }

    /**
     * Извлекает название события для обработки из объекта события.
     *
     * @param object $event
     *
     * @return string
     */
    private function extractEventName(object $event): string
    {
        return get_class($event);
    }
}
