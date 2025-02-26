<?php

namespace Tests\Unit\Domain;

use PHPUnit\Framework\TestCase;
use Domain\Model\User\Email;
use Domain\Exception\InvalidEmailException;

class EmailTest extends TestCase
{
    public function testValidEmail(): void
    {
        $emailString = 'user@example.com';
        $email = Email::fromString($emailString);

        $this->assertEquals($emailString, $email->value());
        $this->assertEquals($emailString, (string)$email);
    }

    public function testInvalidEmail(): void
    {
        $this->expectException(InvalidEmailException::class);
        Email::fromString('invalid-email');
    }

    public function testEmailEquality(): void
    {
        $email1 = Email::fromString('user@example.com');
        $email2 = Email::fromString('user@example.com');
        $email3 = Email::fromString('other@example.com');

        $this->assertTrue($email1->equals($email2));
        $this->assertFalse($email1->equals($email3));
    }
}
