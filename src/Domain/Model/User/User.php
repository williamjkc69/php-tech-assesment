<?php

namespace Domain\Model\User;

use DateTime;
use Domain\Model\Event\UserRegisteredEvent;
use Doctrine\ORM\Mapping as ORM;

/**
 * Entity representing a user in the system
 */
#[ORM\Entity]
#[ORM\Table(name: 'users')]
class User
{
    #[ORM\Id, ORM\Embedded(class: UserId::class)]
    protected UserId $id;

    #[ORM\Embedded(class: Name::class)]
    private Name $name;

    #[ORM\Embedded(class: Email::class)]
    private Email $email;

    #[ORM\Embedded(class: Password::class)]
    private Password $password;

    #[ORM\Column(type: 'datetime')]
    private DateTime $createdAt;

    private array $events = [];

    /**
     * Private constructor for User entity
     *
     * @param UserId $id The unique identifier for the user
     * @param Name $name The user's name
     * @param Email $email The user's email
     * @param Password $password The user's password
     * @param DateTime $createdAt The timestamp when the user was created
     */
    private function __construct(
        UserId $id,
        Name $name,
        Email $email,
        Password $password,
        DateTime $createdAt
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
        $this->createdAt = $createdAt;
    }

    /**
     * Factory method to register a new user
     *
     * @param UserId $id The unique identifier for the user
     * @param Name $name The user's name
     * @param Email $email The user's email
     * @param Password $password The user's password
     * @return self New User entity with registration event
     */
    public static function register(UserId $id, Name $name, Email $email, Password $password): self
    {
        $user = new self(
            $id,
            $name,
            $email,
            $password,
            new DateTime()
        );

        $user->recordEvent(new UserRegisteredEvent($user));

        return $user;
    }

    /**
     * Gets the user's id
     *
     * @return UserId The user's id
     */
    public function id(): UserId
    {
        return $this->id;
    }

    /**
     * Gets the user's name
     *
     * @return Name The user's name
     */
    public function name(): Name
    {
        return $this->name;
    }

    /**
     * Gets the user's email
     *
     * @return Email The user's email
     */
    public function email(): Email
    {
        return $this->email;
    }

    /**
     * Gets the user's password
     *
     * @return Password The user's password
     */
    public function password(): Password
    {
        return $this->password;
    }

    /**
     * Gets the user's creation timestamp
     *
     * @return DateTime The timestamp when the user was created
     */
    public function createdAt(): DateTime
    {
        return $this->createdAt;
    }

    /**
     * Records a domain event for the user
     *
     * @param mixed $event The event to record
     * @return void
     */
    private function recordEvent($event): void
    {
        $this->events[] = $event;
    }

    /**
     * Releases all recorded events and clears the events array
     *
     * @return array All recorded events
     */
    public function releaseEvents(): array
    {
        $events = $this->events;
        $this->events = [];
        return $events;
    }
}
