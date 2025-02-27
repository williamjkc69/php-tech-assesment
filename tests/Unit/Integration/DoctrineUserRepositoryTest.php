<?php

namespace Tests\Integration\Infrastructure\Persistence\Doctrine;

use Doctrine\ORM\EntityManager;
use Domain\Model\User\User;
use Domain\Model\User\UserId;
use Domain\Model\User\Name;
use Domain\Model\User\Email;
use Domain\Model\User\Password;
use Infrastructure\Persistence\Doctrine\DoctrineUserRepository;
use PHPUnit\Framework\TestCase;

class DoctrineUserRepositoryTest extends TestCase
{
    private $entityManager;
    private $userRepository;

    protected function setUp(): void
    {
        // Configuring the EntityManager for testing
        $this->entityManager = require __DIR__ . '/../../../config/bootstrap_test.php';
        $this->userRepository = new DoctrineUserRepository($this->entityManager);

        // Clean database after each test
        $this->entityManager->getConnection()->executeQuery('DELETE FROM users');
    }

    public function testSaveAndFindUser(): void
    {
        // Create an user
        $userId = UserId::fromString("user_12345");
        $name = Name::fromString('John Doe');
        $email = Email::fromString('john@example.com');
        $password = Password::fromPlainPassword('StrongP@ss1');

        $user = User::register($userId, $name, $email, $password);

        // Save the user in the repository
        $this->userRepository->save($user);

        // Search user by ID
        $foundUser = $this->userRepository->findById($userId);

        // Verify that the user has been saved and found correctly.
        $this->assertNotNull($foundUser);
        $this->assertSame($userId->value(), $foundUser->id()->value());
        $this->assertSame('John Doe', $foundUser->name()->value());
        $this->assertSame('john@example.com', $foundUser->email()->value());
    }

    public function testFindByEmail(): void
    {
        // Create an user
        $userId = UserId::fromString("user_12345");
        $name = Name::fromString('Jane Doe');
        $email = Email::fromString('jane@example.com');
        $password = Password::fromPlainPassword('StrongP@ss1');

        $user = User::register($userId, $name, $email, $password);

        // Save the user in the repository
        $this->userRepository->save($user);

        // Search user by email
        $foundUser = $this->userRepository->findByEmail(Email::fromString('jane@example.com'));

        // Verify that the user was found correctly
        $this->assertNotNull($foundUser);
        $this->assertSame($userId->value(), $foundUser->id()->value());
        $this->assertSame('Jane Doe', $foundUser->name()->value());
        $this->assertSame('jane@example.com', $foundUser->email()->value());
    }

    public function testDeleteUser(): void
    {
        // Create an user
        $userId = UserId::fromString("user_12345");
        $name = Name::fromString('Alice Smith');
        $email = Email::fromString('alice@example.com');
        $password = Password::fromPlainPassword('StrongP@ss1');

        $user = User::register($userId, $name, $email, $password);

        // Save the user in the repository
        $this->userRepository->save($user);

        // Delete user
        $this->userRepository->delete($userId);

        // Verify that the user no longer exists
        $foundUser = $this->userRepository->findById($userId);
        $this->assertNull($foundUser);
    }
}
