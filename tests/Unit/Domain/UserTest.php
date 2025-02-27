<?php

namespace Tests\Unit\Domain;

use PHPUnit\Framework\TestCase;
use Domain\Model\User\User;
use Domain\Model\User\UserId;
use Domain\Model\User\Name;
use Domain\Model\User\Email;
use Domain\Model\User\Password;
use Domain\Model\Event\UserRegisteredEvent;

class UserTest extends TestCase
{
    /**
     * Tests the creation of a User entity.
     * Verifies that the User is created with the correct properties and that a UserRegisteredEvent is recorded.
     */
    public function testUserCreation(): void
    {
        // Create required value objects
        $userId = UserId::generate();
        $name = Name::fromString('John Doe');
        $email = Email::fromString('john@example.com');
        $password = Password::fromPlainPassword('StrongP@ss1');

        // Register a new user
        $user = User::register($userId, $name, $email, $password);

        // Assert that the user properties are correctly set
        $this->assertSame($userId, $user->id());
        $this->assertSame($name, $user->name());
        $this->assertSame($email, $user->email());
        $this->assertSame($password, $user->password());
        $this->assertInstanceOf(\DateTime::class, $user->createdAt());

        // Test that the UserRegisteredEvent was recorded
        $events = $user->releaseEvents();
        $this->assertCount(1, $events);
        $this->assertInstanceOf(UserRegisteredEvent::class, $events[0]);
    }
}
