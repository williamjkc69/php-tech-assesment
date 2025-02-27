<?php

namespace Tests\Unit\Domain\Model\User;

use Domain\Model\User\UserId;
use PHPUnit\Framework\TestCase;

class UserIdTest extends TestCase
{
    public function testGenerate(): void
    {
        $userId = UserId::generate();

        $this->assertNotEmpty($userId->value());
        $this->assertStringStartsWith('user_', $userId->value());
    }

    public function testFromString(): void
    {
        $userIdString = 'user_12345';
        $userId = UserId::fromString($userIdString);

        $this->assertSame($userIdString, $userId->value());
    }

    public function testFromStringWithEmptyValue(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('User ID cannot be empty');

        UserId::fromString('');
    }

    public function testEquals(): void
    {
        $userId1 = UserId::fromString('user_12345');
        $userId2 = UserId::fromString('user_12345');
        $userId3 = UserId::fromString('user_67890');

        $this->assertTrue($userId1->equals($userId2));
        $this->assertFalse($userId1->equals($userId3));
    }

    public function testValue(): void
    {
        $userIdString = 'user_12345';
        $userId = UserId::fromString($userIdString);

        $this->assertSame($userIdString, $userId->value());
    }

    public function testToString(): void
    {
        $userIdString = 'user_12345';
        $userId = UserId::fromString($userIdString);

        $this->assertSame($userIdString, (string) $userId);
    }
}
