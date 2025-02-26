<?php

namespace Domain\Model\User;

use Domain\Exception\WeakPasswordException;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Embeddable]
class Password
{
    #[ORM\Column(type: 'string')]
    private string $hashedValue;
    private const MIN_LENGTH = 8;
    private const UPPERCASE_PATTERN = '/[A-Z]/';
    private const NUMBER_PATTERN = '/[0-9]/';
    private const SPECIAL_CHAR_PATTERN = '/[^a-zA-Z0-9]/';

    private function __construct(string $hashedValue)
    {
        $this->hashedValue = $hashedValue;
    }

    public static function fromPlainPassword(string $plainPassword): self
    {
        self::validatePassword($plainPassword);
        return new self(password_hash($plainPassword, PASSWORD_BCRYPT, ['cost' => 12]));
    }

    public static function fromHash(string $hash): self
    {
        if (empty($hash)) {
            throw new \InvalidArgumentException('Password hash cannot be empty');
        }
        return new self($hash);
    }

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

    public function verify(string $plainPassword): bool
    {
        return password_verify($plainPassword, $this->hashedValue);
    }

    public function value(): string
    {
        return $this->hashedValue;
    }
}
