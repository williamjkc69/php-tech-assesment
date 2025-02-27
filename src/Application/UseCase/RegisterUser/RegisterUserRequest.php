<?php

namespace Application\UseCase\RegisterUser;

/**
 * Data Transfer Object for user registration requests.
 */
class RegisterUserRequest
{
    private string $name;
    private string $email;
    private string $password;

    /**
     * Creates a new user registration request.
     *
     * @param string $name The name of the user
     * @param string $email The email address of the user
     * @param string $password The password for the user account
     */
    public function __construct(string $name, string $email, string $password)
    {
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
    }

    /**
     * Gets the user's name.
     *
     * @return string The user's name
     */
    public function name(): string
    {
        return $this->name;
    }

    /**
     * Gets the user's email address.
     *
     * @return string The user's email address
     */
    public function email(): string
    {
        return $this->email;
    }

    /**
     * Gets the user's password.
     *
     * @return string The user's password
     */
    public function password(): string
    {
        return $this->password;
    }
}
