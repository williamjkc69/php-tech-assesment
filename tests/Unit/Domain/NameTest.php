<?php

namespace Tests\Unit\Domain\Model\User;

use Domain\Model\User\Name;
use PHPUnit\Framework\TestCase;

class NameTest extends TestCase
{
    /**
     * Tests the creation of a valid name.
     * Verifies that the name value is correctly set and can be cast to a string.
     */
    public function testValidName(): void
    {
        $nameString = 'John Doe';
        $name = Name::fromString($nameString);

        // Assert that the name value matches the input string
        $this->assertSame($nameString, $name->value());
        // Assert that the name object can be cast to a string
        $this->assertSame($nameString, (string) $name);
    }

    /**
     * Tests the creation of a name that is too short.
     * Verifies that an InvalidArgumentException is thrown with the correct message.
     */
    public function testNameTooShort(): void
    {
        // Expect an InvalidArgumentException to be thrown
        $this->expectException(\InvalidArgumentException::class);
        // Expect the exception message to indicate the name is too short
        $this->expectExceptionMessage('Name must be at least 2 characters long');

        // Attempt to create a name with only 1 character
        Name::fromString('J');
    }

    /**
     * Tests the creation of a name that is too long.
     * Verifies that an InvalidArgumentException is thrown with the correct message.
     */
    public function testNameTooLong(): void
    {
        // Create a name with 101 characters
        $longName = str_repeat('a', 101);
        // Expect an InvalidArgumentException to be thrown
        $this->expectException(\InvalidArgumentException::class);
        // Expect the exception message to indicate the name is too long
        $this->expectExceptionMessage('Name cannot exceed 100 characters');

        // Attempt to create a name with 101 characters
        Name::fromString($longName);
    }

    /**
     * Tests the creation of a name with invalid characters.
     * Verifies that an InvalidArgumentException is thrown with the correct message.
     */
    public function testNameWithInvalidCharacters(): void
    {
        $invalidName = 'John@Doe';
        // Expect an InvalidArgumentException to be thrown
        $this->expectException(\InvalidArgumentException::class);
        // Expect the exception message to indicate invalid characters
        $this->expectExceptionMessage('Name contains invalid characters');

        // Attempt to create a name with invalid characters
        Name::fromString($invalidName);
    }

    /**
     * Tests the value method of the Name class.
     * Verifies that the value method returns the correct name string.
     */
    public function testValueMethod(): void
    {
        $nameString = 'Jane Doe';
        $name = Name::fromString($nameString);

        // Assert that the value method returns the correct name string
        $this->assertSame($nameString, $name->value());
    }

    /**
     * Tests the __toString method of the Name class.
     * Verifies that the name object can be cast to a string correctly.
     */
    public function testToStringMethod(): void
    {
        $nameString = 'Alice Smith';
        $name = Name::fromString($nameString);

        // Assert that the name object can be cast to a string correctly
        $this->assertSame($nameString, (string) $name);
    }
}
