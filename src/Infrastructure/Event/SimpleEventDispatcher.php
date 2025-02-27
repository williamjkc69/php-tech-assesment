<?php

namespace Infrastructure\Event;

use Application\Event\EventDispatcher;
use Application\Event\EventListener;
use Domain\Model\Event\DomainEvent;

class SimpleEventDispatcher implements EventDispatcher
{
    private array $listeners = [];

    /**
     * Dispatches a domain event to all registered listeners for that event type.
     *
     * @param DomainEvent $event The domain event to dispatch.
     * @return void
     */
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

    /**
     * Adds a listener for a specific event class.
     *
     * @param string $eventClass The class name of the event to listen for.
     * @param EventListener $listener The listener to handle the event.
     * @return void
     */
    public function addListener(string $eventClass, EventListener $listener): void
    {
        if (!isset($this->listeners[$eventClass])) {
            $this->listeners[$eventClass] = [];
        }

        $this->listeners[$eventClass][] = $listener;
    }
}
