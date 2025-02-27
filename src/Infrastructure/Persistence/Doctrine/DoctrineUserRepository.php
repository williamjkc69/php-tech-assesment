<?php

namespace Infrastructure\Persistence\Doctrine;

use Doctrine\ORM\EntityManager;
use Domain\Model\User\User;
use Domain\Model\User\UserId;
use Domain\Model\User\Email;
use Domain\Repository\UserRepositoryInterface;

class DoctrineUserRepository implements UserRepositoryInterface
{
    private EntityManager $entityManager;

    /**
     * Constructor for DoctrineUserRepository.
     *
     * @param EntityManager $entityManager The Doctrine EntityManager instance.
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * Saves a user entity to the database.
     *
     * @param User $user The user entity to save.
     * @return void
     */
    public function save(User $user): void
    {
        $this->entityManager->persist($user);
        $this->entityManager->flush();
    }

    /**
     * Finds a user by their unique identifier.
     *
     * @param UserId $id The user ID to search for.
     * @return User|null Returns the User entity if found, otherwise null.
     */
    public function findById(UserId $id): ?User
    {
        return $this->entityManager->find(User::class, $id->value());
    }

    /**
     * Finds a user by their email address.
     *
     * @param Email $email The email address to search for.
     * @return User|null Returns the User entity if found, otherwise null.
     */
    public function findByEmail(Email $email): ?User
    {
        return $this->entityManager->getRepository(User::class)
            ->findOneBy(['email.value' => $email->value()]);
    }

    /**
     * Deletes a user by their unique identifier.
     *
     * @param UserId $id The user ID of the user to delete.
     * @return void
     */
    public function delete(UserId $id): void
    {
        $user = $this->findById($id);
        if ($user) {
            $this->entityManager->remove($user);
            $this->entityManager->flush();
        }
    }
}
