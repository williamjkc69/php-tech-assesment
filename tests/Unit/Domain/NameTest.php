<?php

namespace Tests\Unit\Domain\Model\User;

use Domain\Model\User\Name;
use PHPUnit\Framework\TestCase;

class NameTest extends TestCase
{
    public function testValidName(): void
    {
        $nameString = 'John Doe';
        $name = Name::fromString($nameString);

        $this->assertSame($nameString, $name->value());
        $this->assertSame($nameString, (string) $name);
    }

    public function testNameTooShort(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Name must be at least 2 characters long');

        Name::fromString('J');
    }

    public function testNameTooLong(): void
    {
        $longName = str_repeat('a', 101); // 101 characters
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Name cannot exceed 100 characters');

        Name::fromString($longName);
    }

    public function testNameWithInvalidCharacters(): void
    {
        $invalidName = 'John@Doe';
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Name contains invalid characters');

        Name::fromString($invalidName);
    }

    public function testValueMethod(): void
    {
        $nameString = 'Jane Doe';
        $name = Name::fromString($nameString);

        $this->assertSame($nameString, $name->value());
    }

    public function testToStringMethod(): void
    {
        $nameString = 'Alice Smith';
        $name = Name::fromString($nameString);

        $this->assertSame($nameString, (string) $name);
    }
}
