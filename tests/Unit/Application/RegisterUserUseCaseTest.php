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

    protected function setUp(): void
    {
        $this->userRepository = $this->createMock(UserRepositoryInterface::class);
        $this->eventDispatcher = $this->createMock(EventDispatcher::class);
        $this->registerUserUseCase = new RegisterUserUseCase($this->userRepository, $this->eventDispatcher);
    }

    public function testExecuteSuccess(): void
    {
        $request = new RegisterUserRequest('John Doe', 'john@example.com', 'StrongP@ss1');

        $this->userRepository->method('findByEmail')->willReturn(null);
        $this->userRepository->expects($this->once())->method('save');

        $this->eventDispatcher->expects($this->once())->method('dispatch');

        $response = $this->registerUserUseCase->execute($request);

        $this->assertInstanceOf(UserResponseDTO::class, $response);
    }

    public function testExecuteUserAlreadyExists(): void
    {
        $request = new RegisterUserRequest('John Doe', 'john@example.com', 'StrongP@ss1');

        $this->userRepository->method('findByEmail')->willReturn(new User(
            UserId::generate(),
            Name::fromString('John Doe'),
            Email::fromString('john@example.com'),
            Password::fromPlainPassword('StrongP@ss1'),
            new \DateTime()
        ));

        $this->expectException(UserAlreadyExistsException::class);

        $this->registerUserUseCase->execute($request);
    }
}
