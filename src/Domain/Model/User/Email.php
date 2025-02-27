<?php

namespace Domain\Model\User;

use Domain\Exception\InvalidEmailException;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Embeddable]
class Email
{
    #[ORM\Column(type: 'string')]
    private string $value;

    /**
     * Private constructor to enforce creation through named constructors.
     *
     * @param string $value The email address value
     */
    private function __construct(string $value)
    {
        $this->value = $value;
    }

    /**
     * Creates a new Email instance from a string value.
     *
     * @param string $email The email address string
     * @return self New Email instance
     * @throws InvalidEmailException When the email format is invalid
     */
    public static function fromString(string $email): self
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidEmailException('Invalid email format');
        }
        return new self($email);
    }

    /**
     * Gets the email address value.
     *
     * @return string The email address
     */
    public function value(): string
    {
        return $this->value;
    }

    /**
     * Compares this email with another email for equality.
     *
     * @param Email $other The other email to compare with
     * @return bool True if both emails are equal, false otherwise
     */
    public function equals(Email $other): bool
    {
        return $this->value === $other->value;
    }

    /**
     * Returns the string representation of the email.
     *
     * @return string The email address
     */
    public function __toString(): string
    {
        return $this->value;
    }
}
