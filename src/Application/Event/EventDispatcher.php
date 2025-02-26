<?php

namespace Application\Event;

use Domain\Model\Event\DomainEvent;

interface EventDispatcher
{
    public function dispatch(DomainEvent $event): void;
    public function addListener(string $eventClass, EventListener $listener): void;
}
