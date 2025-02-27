<?php

namespace Tests\Unit\Domain\Model\User;

use Domain\Model\User\UserId;
use PHPUnit\Framework\TestCase;

class UserIdTest extends TestCase
{
    /**
     * Tests the generation of a UserId.
     * Verifies that the generated UserId is not empty and starts with the prefix 'user_'.
     */
    public function testGenerate(): void
    {
        // Generate a new UserId
        $userId = UserId::generate();

        // Assert that the UserId value is not empty
        $this->assertNotEmpty($userId->value());
        // Assert that the UserId value starts with 'user_'
        $this->assertStringStartsWith('user_', $userId->value());
    }

    /**
     * Tests the creation of a UserId from a string.
     * Verifies that the UserId value matches the input string.
     */
    public function testFromString(): void
    {
        $userIdString = 'user_12345';
        // Create a UserId from the string
        $userId = UserId::fromString($userIdString);

        // Assert that the UserId value matches the input string
        $this->assertSame($userIdString, $userId->value());
    }

    /**
     * Tests the creation of a UserId from an empty string.
     * Verifies that an InvalidArgumentException is thrown with the correct message.
     */
    public function testFromStringWithEmptyValue(): void
    {
        // Expect an InvalidArgumentException to be thrown
        $this->expectException(\InvalidArgumentException::class);
        // Expect the exception message to indicate that the User ID cannot be empty
        $this->expectExceptionMessage('User ID cannot be empty');

        // Attempt to create a UserId from an empty string
        UserId::fromString('');
    }

    /**
     * Tests the equality comparison of two UserId objects.
     */
    public function testEquals(): void
    {
        // Create two UserIds with the same value
        $userId1 = UserId::fromString('user_12345');
        $userId2 = UserId::fromString('user_12345');
        // Create a UserId with a different value
        $userId3 = UserId::fromString('user_67890');

        // Assert that the first and second UserIds are equal
        $this->assertTrue($userId1->equals($userId2));
        // Assert that the first and third UserIds are not equal
        $this->assertFalse($userId1->equals($userId3));
    }

    /**
     * Tests the value method of the UserId class.
     * Verifies that the value method returns the correct UserId string.
     */
    public function testValue(): void
    {
        $userIdString = 'user_12345';
        // Create a UserId from the string
        $userId = UserId::fromString($userIdString);

        // Assert that the value method returns the correct UserId string
        $this->assertSame($userIdString, $userId->value());
    }

    /**
     * Tests the __toString method of the UserId class.
     * Verifies that the UserId object can be cast to a string correctly.
     */
    public function testToString(): void
    {
        $userIdString = 'user_12345';
        // Create a UserId from the string
        $userId = UserId::fromString($userIdString);

        // Assert that the UserId object can be cast to a string correctly
        $this->assertSame($userIdString, (string) $userId);
    }
}
