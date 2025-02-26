<?php

// tests/Unit/Domain/PasswordTest.php

namespace Tests\Unit\Domain;

use PHPUnit\Framework\TestCase;
use Domain\Model\User\Password;
use Domain\Exception\WeakPasswordException;

class PasswordTest extends TestCase
{
    public function testValidPassword(): void
    {
        $password = Password::fromPlainPassword('StrongP@ss1');
        $this->assertTrue($password->verify('StrongP@ss1'));
    }

    public function testWeakPassword(): void
    {
        $this->expectException(WeakPasswordException::class);
        Password::fromPlainPassword('weak');
    }

    public function testPasswordEquality(): void
    {
        $password1 = Password::fromPlainPassword('StrongP@ss1');
        $password2 = Password::fromPlainPassword('StrongP@ss1');
        $password3 = Password::fromPlainPassword('AnotherP@ss1');

        $this->assertTrue($password1->verify('StrongP@ss1'));
        $this->assertTrue($password2->verify('StrongP@ss1'));
        $this->assertFalse($password1->verify('AnotherP@ss1'));
    }
}
