<?php

namespace Tests\Unit\Domain;

use PHPUnit\Framework\TestCase;
use Domain\Model\User\Password;
use Domain\Exception\WeakPasswordException;

class PasswordTest extends TestCase
{
    /**
     * Tests the creation of a valid password.
     * Verifies that the password can be created and verified successfully.
     */
    public function testValidPassword(): void
    {
        // Create a password from a plain text password
        $password = Password::fromPlainPassword('StrongP@ss1');
        // Assert that the password can be verified successfully
        $this->assertTrue($password->verify('StrongP@ss1'));
    }

    /**
     * Tests the creation of a weak password.
     * Verifies that a WeakPasswordException is thrown for weak passwords.
     */
    public function testWeakPassword(): void
    {
        // Expect a WeakPasswordException to be thrown
        $this->expectException(WeakPasswordException::class);
        // Attempt to create a password with a weak value
        Password::fromPlainPassword('weak');
    }

    /**
     * Tests the equality and verification of passwords.
     * Verifies that two passwords with the same value can be verified successfully,
     * and that a password cannot be verified with a different value.
     */
    public function testPasswordEquality(): void
    {
        // Create two passwords with the same value
        $password1 = Password::fromPlainPassword('StrongP@ss1');
        $password2 = Password::fromPlainPassword('StrongP@ss1');
        // Create a password with a different value
        $password3 = Password::fromPlainPassword('AnotherP@ss1');

        // Assert that the first password can be verified with the correct value
        $this->assertTrue($password1->verify('StrongP@ss1'));
        // Assert that the second password can be verified with the correct value
        $this->assertTrue($password2->verify('StrongP@ss1'));
        // Assert that the first password cannot be verified with a different value
        $this->assertFalse($password1->verify('AnotherP@ss1'));
    }
}
