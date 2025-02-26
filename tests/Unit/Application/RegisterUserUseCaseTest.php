<?php

// tests/Unit/Application/RegisterUserUseCaseTest.php

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
    private $userRepository;
    private $eventDispatcher;
    private $registerUserUseCase;

    public $fakeUser = [
        'name' => 'John Doe',
        'email' => 'john@example.com',
        'password' => 'StrongP@ss1'
    ];

    protected function setUp(): void
    {
        $this->userRepository = $this->createMock(UserRepositoryInterface::class);
        $this->eventDispatcher = $this->createMock(EventDispatcher::class);
        $this->registerUserUseCase = new RegisterUserUseCase($this->userRepository, $this->eventDispatcher);
    }

    public function testExecuteSuccess(): void
    {
        $request = new RegisterUserRequest($this->fakeUser['name'], $this->fakeUser['email'], $this->fakeUser['password']);

        $this->userRepository->method('findByEmail')->willReturn(null);
        $this->userRepository->expects($this->once())->method('save');

        $this->eventDispatcher->expects($this->once())->method('dispatch');

        $response = $this->registerUserUseCase->execute($request);

        $this->assertInstanceOf(UserResponseDTO::class, $response);
    }

    public function testExecuteUserAlreadyExists(): void
    {
        $request = new RegisterUserRequest($this->fakeUser['name'], $this->fakeUser['email'], $this->fakeUser['password']);

        // Use the factory method to create a User instance
        $user = User::register(
            UserId::generate(),
            Name::fromString($this->fakeUser['name']),
            Email::fromString($this->fakeUser['email']),
            Password::fromPlainPassword($this->fakeUser['password'])
        );

        // Mock the repository to return the User instance
        $this->userRepository->method('findByEmail')->willReturn($user);

        // Expect the UserAlreadyExistsException to be thrown
        $this->expectException(UserAlreadyExistsException::class);

        // Execute the use case
        $this->registerUserUseCase->execute($request);
    }
}
