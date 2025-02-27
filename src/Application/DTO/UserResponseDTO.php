<?php

namespace Application\DTO;

/**
 * Represents a Data Transfer Object (DTO) for user responses.
 */
class UserResponseDTO
{
    private string $id;
    private string $name;
    private string $email;
    private string $createdAt;

    /**
     * Initializes a new instance of the UserResponseDTO class.
     */
    public function __construct(string $id, string $name, string $email, string $createdAt)
    {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
        $this->createdAt = $createdAt;
    }

    /**
     * Converts the UserResponseDTO object to an associative array.
     *
     * @return array An associative array containing the user data.
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'createdAt' => $this->createdAt
        ];
    }

    /**
     * Converts the UserResponseDTO object to a JSON string.
     *
     * @return string A JSON-encoded string representing the user data.
     */
    public function toJson(): string
    {
        return json_encode($this->toArray());
    }
}
