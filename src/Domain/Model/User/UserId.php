<?php

namespace Domain\Model\User;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Embeddable]
class UserId
{
    #[ORM\Id, ORM\Column(type: 'string')]
    private string $value;

    /**
     * Private constructor to create a UserId instance.
     *
     * @param string $value The unique identifier value.
     */
    private function __construct(string $value)
    {
        $this->value = $value;
    }

    /**
     * Generates a new UserId with a unique value.
     *
     * @return self Returns a new instance of UserId.
     */
    public static function generate(): self
    {
        return new self(uniqid('user_'));
    }

    /**
     * Creates a UserId instance from a string.
     *
     * @param string $value The string value to create the UserId from.
     * @return self Returns a new instance of UserId.
     * @throws \InvalidArgumentException If the provided value is empty.
     */
    public static function fromString(string $value): self
    {
        if (empty($value)) {
            throw new \InvalidArgumentException('User ID cannot be empty');
        }
        return new self($value);
    }

    /**
     * Returns the value of the UserId.
     *
     * @return string The unique identifier value.
     */
    public function value(): string
    {
        return $this->value;
    }

    /**
     * Compares this UserId with another UserId for equality.
     *
     * @param UserId $other The other UserId to compare with.
     * @return bool Returns true if the values are equal, false otherwise.
     */
    public function equals(UserId $other): bool
    {
        return $this->value === $other->value;
    }

    /**
     * Returns the string representation of the UserId.
     *
     * @return string The unique identifier value as a string.
     */
    public function __toString(): string
    {
        return $this->value;
    }
}
