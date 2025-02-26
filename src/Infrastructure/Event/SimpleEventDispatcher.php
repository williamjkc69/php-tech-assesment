<?php

namespace Infrastructure\Event;

use Application\Event\EventDispatcher;
use Application\Event\EventListener;
use Domain\Model\Event\DomainEvent;

class SimpleEventDispatcher implements EventDispatcher
{
    private array $listeners = [];

    public function dispatch(DomainEvent $event): void
    {
        $eventClass = get_class($event);

        if (!isset($this->listeners[$eventClass])) {
            return;
        }

        foreach ($this->listeners[$eventClass] as $listener) {
            $listener->handle($event);
        }
    }

    public function addListener(string $eventClass, EventListener $listener): void
    {
        if (!isset($this->listeners[$eventClass])) {
            $this->listeners[$eventClass] = [];
        }

        $this->listeners[$eventClass][] = $listener;
    }
}
