<?php

namespace Domain\Model\User;

class Name
{
    private string $value;
    private const MIN_LENGTH = 2;
    private const MAX_LENGTH = 100;
    private const PATTERN = '/^[a-zA-Z0-9\s]+$/';

    private function __construct(string $value)
    {
        $this->value = $value;
    }

    public static function fromString(string $name): self
    {
        if (strlen($name) < self::MIN_LENGTH) {
            throw new \InvalidArgumentException(
                "Name must be at least " . self::MIN_LENGTH . " characters long"
            );
        }

        if (strlen($name) > self::MAX_LENGTH) {
            throw new \InvalidArgumentException(
                "Name cannot exceed " . self::MAX_LENGTH . " characters"
            );
        }

        if (!preg_match(self::PATTERN, $name)) {
            throw new \InvalidArgumentException(
                "Name contains invalid characters"
            );
        }

        return new self($name);
    }

    public function value(): string
    {
        return $this->value;
    }

    public function __toString(): string
    {
        return $this->value;
    }
}
