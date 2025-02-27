<?php

namespace Domain\Model\Event;

use Domain\Model\User\User;

/**
 * Event triggered when a new user has been registered.
 */
class UserRegisteredEvent implements DomainEvent
{
    private User $user;
    private \DateTime $occurredOn;

    /**
     * Creates a new user registered event.
     *
     * @param User $user The user that was registered
     */
    public function __construct(User $user)
    {
        $this->user = $user;
        $this->occurredOn = new \DateTime();
    }

    /**
     * Gets the registered user.
     *
     * @return User The registered user
     */
    public function user(): User
    {
        return $this->user;
    }

    /**
     * Gets the date and time when this event occurred.
     *
     * @return \DateTime The occurrence date and time
     */
    public function occurredOn(): \DateTime
    {
        return $this->occurredOn;
    }
}
