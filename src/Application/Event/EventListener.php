<?php

namespace Application\Event;

use Domain\Model\Event\DomainEvent;

interface EventListener
{
    public function handle(DomainEvent $event): void;
}
