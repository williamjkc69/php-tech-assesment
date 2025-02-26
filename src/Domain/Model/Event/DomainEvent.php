<?php

namespace Domain\Model\Event;

interface DomainEvent
{
    public function occurredOn(): \DateTime;
}
