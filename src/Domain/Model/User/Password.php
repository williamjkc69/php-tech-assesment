<?php

namespace Domain\Model\User;

use Domain\Exception\WeakPasswordException;
use Doctrine\ORM\Mapping as ORM;

/**
 * Value object representing a user password
 */
#[ORM\Embeddable]
class Password
{
    #[ORM\Column(type: 'string')]
    private string $hashedValue;
    private const MIN_LENGTH = 8;
    private const UPPERCASE_PATTERN = '/[A-Z]/';
    private const NUMBER_PATTERN = '/[0-9]/';
    private const SPECIAL_CHAR_PATTERN = '/[^a-zA-Z0-9]/';

    /**
     * Private constructor for Password object
     *
     * @param string $hashedValue The hashed password value
     */
    private function __construct(string $hashedValue)
    {
        $this->hashedValue = $hashedValue;
    }

    /**
     * Creates a Password object from a plain text password
     *
     * @param string $plainPassword The plain text password to hash
     * @return self New Password object with hashed value
     * @throws WeakPasswordException If password doesn't meet requirements
     */
    public static function fromPlainPassword(string $plainPassword): self
    {
        self::validatePassword($plainPassword);
        return new self(password_hash($plainPassword, PASSWORD_BCRYPT, ['cost' => 12]));
    }

    /**
     * Creates a Password object from an existing hash
     *
     * @param string $hash The existing password hash
     * @return self New Password object with the provided hash
     * @throws \InvalidArgumentException If hash is empty
     */
    public static function fromHash(string $hash): self
    {
        if (empty($hash)) {
            throw new \InvalidArgumentException('Password hash cannot be empty');
        }
        return new self($hash);
    }

    /**
     * Validates a password against security requirements
     *
     * @param string $password The plain text password to validate
     * @return void
     * @throws WeakPasswordException If password doesn't meet requirements
     */
    private static function validatePassword(string $password): void
    {
        $errors = [];

        if (strlen($password) < self::MIN_LENGTH) {
            $errors[] = "Password must be at least " . self::MIN_LENGTH . " characters long";
        }

        if (!preg_match(self::UPPERCASE_PATTERN, $password)) {
            $errors[] = "Password must contain at least one uppercase letter";
        }

        if (!preg_match(self::NUMBER_PATTERN, $password)) {
            $errors[] = "Password must contain at least one number";
        }

        if (!preg_match(self::SPECIAL_CHAR_PATTERN, $password)) {
            $errors[] = "Password must contain at least one special character";
        }

        if (!empty($errors)) {
            throw new WeakPasswordException(implode(', ', $errors));
        }
    }

    /**
     * Verifies if a plain text password matches this Password
     *
     * @param string $plainPassword The plain text password to verify
     * @return bool True if password matches, false otherwise
     */
    public function verify(string $plainPassword): bool
    {
        return password_verify($plainPassword, $this->hashedValue);
    }

    /**
     * Gets the hashed password value
     *
     * @return string The hashed password
     */
    public function value(): string
    {
        return $this->hashedValue;
    }
}
