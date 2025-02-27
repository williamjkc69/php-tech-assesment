<?php

namespace Tests\Unit\Domain;

use PHPUnit\Framework\TestCase;
use Domain\Model\User\Email;
use Domain\Exception\InvalidEmailException;

class EmailTest extends TestCase
{
    /**
     * Tests the creation of a valid email.
     * Verifies that the email value is correctly set and can be cast to a string.
     */
    public function testValidEmail(): void
    {
        $emailString = 'user@example.com';
        $email = Email::fromString($emailString);

        // Assert that the email value matches the input string
        $this->assertEquals($emailString, $email->value());
        // Assert that the email object can be cast to a string
        $this->assertEquals($emailString, (string)$email);
    }

    /**
     * Tests the creation of an invalid email.
     * Verifies that an InvalidEmailException is thrown for invalid email formats.
     */
    public function testInvalidEmail(): void
    {
        // Expect an InvalidEmailException to be thrown
        $this->expectException(InvalidEmailException::class);
        // Attempt to create an email with an invalid format
        Email::fromString('invalid-email');
    }

    /**
     * Tests the equality comparison of two email objects.
     * Verifies that two emails with the same value are considered equal,
     * and emails with different values are not.
     */
    public function testEmailEquality(): void
    {
        $email1 = Email::fromString('user@example.com');
        $email2 = Email::fromString('user@example.com');
        $email3 = Email::fromString('other@example.com');

        // Assert that two emails with the same value are equal
        $this->assertTrue($email1->equals($email2));
        // Assert that two emails with different values are not equal
        $this->assertFalse($email1->equals($email3));
    }
}
