<?php

namespace Tests\Unit\Application;

use PHPUnit\Framework\TestCase;
use Application\UseCase\RegisterUser\RegisterUserUseCase;
use Application\UseCase\RegisterUser\RegisterUserRequest;
use Domain\Model\User\User;
use Domain\Model\User\UserId;
use Domain\Model\User\Name;
use Domain\Model\User\Email;
use Domain\Model\User\Password;
use Domain\Repository\UserRepositoryInterface;
use Domain\Exception\UserAlreadyExistsException;
use Application\Event\EventDispatcher;
use Application\DTO\UserResponseDTO;

class RegisterUserUseCaseTest extends TestCase
{
    /** @var UserRepositoryInterface Mock user repository. */
    private $userRepository;

    /** @var EventDispatcher Mock event dispatcher. */
    private $eventDispatcher;

    /** @var RegisterUserUseCase The use case being tested. */
    private $registerUserUseCase;

    /** @var array Fake user data for testing. */
    public $fakeUser = [
        'name' => 'John Doe',
        'email' => 'john@example.com',
        'password' => 'StrongP@ss1'
    ];

    /**
     * Set up the test environment.
     * Initializes mocks and the RegisterUserUseCase instance.
     */
    protected function setUp(): void
    {
        $this->userRepository = $this->createMock(UserRepositoryInterface::class);
        $this->eventDispatcher = $this->createMock(EventDispatcher::class);
        $this->registerUserUseCase = new RegisterUserUseCase($this->userRepository, $this->eventDispatcher);
    }

    /**
     * Tests the successful execution of the RegisterUserUseCase.
     * Verifies that a user is saved and an event is dispatched.
     */
    public function testExecuteSuccess(): void
    {
        $request = new RegisterUserRequest($this->fakeUser['name'], $this->fakeUser['email'], $this->fakeUser['password']);

        // Mock the repository to return null (user does not exist)
        $this->userRepository->method('findByEmail')->willReturn(null);
        // Expect the save method to be called once
        $this->userRepository->expects($this->once())->method('save');

        // Expect the event dispatcher to dispatch an event once
        $this->eventDispatcher->expects($this->once())->method('dispatch');

        // Execute the use case
        $response = $this->registerUserUseCase->execute($request);

        // Assert that the response is an instance of UserResponseDTO
        $this->assertInstanceOf(UserResponseDTO::class, $response);
    }

    /**
     * Tests the scenario where a user already exists.
     * Verifies that the UserAlreadyExistsException is thrown.
     */
    public function testExecuteUserAlreadyExists(): void
    {
        $request = new RegisterUserRequest($this->fakeUser['name'], $this->fakeUser['email'], $this->fakeUser['password']);

        // Create a fake user instance
        $user = User::register(
            UserId::generate(),
            Name::fromString($this->fakeUser['name']),
            Email::fromString($this->fakeUser['email']),
            Password::fromPlainPassword($this->fakeUser['password'])
        );

        // Mock the repository to return the fake user (user already exists)
        $this->userRepository->method('findByEmail')->willReturn($user);

        // Expect the UserAlreadyExistsException to be thrown
        $this->expectException(UserAlreadyExistsException::class);

        // Execute the use case
        $this->registerUserUseCase->execute($request);
    }
}
