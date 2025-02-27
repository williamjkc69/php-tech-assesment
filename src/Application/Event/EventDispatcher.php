<?php

namespace Application\Event;

use Domain\Model\Event\DomainEvent;

/**
 * Interface for dispatching domain events to registered listeners.
 */
interface EventDispatcher
{
    /**
     * Dispatches a domain event to all registered listeners.
     *
     * @param DomainEvent $event The domain event to be dispatched
     * @return void
     */
    public function dispatch(DomainEvent $event): void;

    /**
     * Registers an event listener for a specific event class.
     *
     * @param string $eventClass The fully qualified class name of the event
     * @param EventListener $listener The listener to be registered
     * @return void
     */
    public function addListener(string $eventClass, EventListener $listener): void;
}
