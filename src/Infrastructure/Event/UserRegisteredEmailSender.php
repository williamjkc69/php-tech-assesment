<?php

namespace Infrastructure\Event;

use Application\Event\EventListener;
use Domain\Model\Event\DomainEvent;
use Domain\Model\Event\UserRegisteredEvent;

class UserRegisteredEmailSender implements EventListener
{
    /**
     * Handles the domain event by sending a welcome email to the newly registered user.
     * Only processes events of type `UserRegisteredEvent`.
     *
     * @param DomainEvent $event The domain event to handle.
     * @return void
     */
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
