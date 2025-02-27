<?php

namespace Domain\Repository;

use Domain\Model\User\User;
use Domain\Model\User\UserId;
use Domain\Model\User\Email;

interface UserRepositoryInterface
{
    /**
     * Saves a user entity to the repository.
     *
     * @param User $user The user entity to save.
     * @return void
     */
    public function save(User $user): void;

    /**
     * Finds a user by their unique identifier.
     *
     * @param UserId $id The user ID to search for.
     * @return User|null Returns the User entity if found, otherwise null.
     */
    public function findById(UserId $id): ?User;

    /**
     * Finds a user by their email address.
     *
     * @param Email $email The email address to search for.
     * @return User|null Returns the User entity if found, otherwise null.
     */
    public function findByEmail(Email $email): ?User;

    /**
     * Deletes a user by their unique identifier.
     *
     * @param UserId $id The user ID of the user to delete.
     * @return void
     */
    public function delete(UserId $id): void;
}
