<?php

namespace Domain\Model\User;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Embeddable]
class UserId
{
    #[ORM\Id, ORM\Column(type: 'string')]
    private string $value;

    private function __construct(string $value)
    {
        $this->value = $value;
    }

    public static function generate(): self
    {
        return new self(uniqid('user_'));
    }

    public static function fromString(string $value): self
    {
        if (empty($value)) {
            throw new \InvalidArgumentException('User ID cannot be empty');
        }
        return new self($value);
    }

    public function value(): string
    {
        return $this->value;
    }

    public function equals(UserId $other): bool
    {
        return $this->value === $other->value;
    }

    public function __toString(): string
    {
        return $this->value;
    }
}
