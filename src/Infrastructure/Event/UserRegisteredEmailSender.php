<?php

namespace Infrastructure\Event;

use Application\Event\EventListener;
use Domain\Model\Event\DomainEvent;
use Domain\Model\Event\UserRegisteredEvent;

class UserRegisteredEmailSender implements EventListener
{
    public function handle(DomainEvent $event): void
    {
        if (!$event instanceof UserRegisteredEvent) {
            return;
        }

        $user = $event->user();

        // Here you would normally send an actual email
        // For this example, we're just simulating the action
        echo "Sending welcome email to: " . $user->email()->value() . PHP_EOL;
    }
}
