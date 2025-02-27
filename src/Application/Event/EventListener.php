<?php

namespace Application\Event;

use Domain\Model\Event\DomainEvent;

/**
 * Interface for handling domain events.
 */
interface EventListener
{
    /**
     * Handles a domain event.
     *
     * @param DomainEvent $event The domain event to be handled
     * @return void
     */
    public function handle(DomainEvent $event): void;
}
