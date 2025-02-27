<?php

namespace Application\UseCase\RegisterUser;

use Domain\Model\User\User;
use Domain\Model\User\UserId;
use Domain\Model\User\Name;
use Domain\Model\User\Email;
use Domain\Model\User\Password;
use Domain\Repository\UserRepositoryInterface;
use Domain\Exception\UserAlreadyExistsException;
use Application\DTO\UserResponseDTO;
use Application\Event\EventDispatcher;

/**
 * Use case for registering a new user in the system.
 */
class RegisterUserUseCase
{
    private UserRepositoryInterface $userRepository;
    private EventDispatcher $eventDispatcher;

    /**
     * Creates a new register user use case.
     *
     * @param UserRepositoryInterface $userRepository Repository for user persistence
     * @param EventDispatcher $eventDispatcher Dispatcher for domain events
     */
    public function __construct(
        UserRepositoryInterface $userRepository,
        EventDispatcher $eventDispatcher
    ) {
        $this->userRepository = $userRepository;
        $this->eventDispatcher = $eventDispatcher;
    }

    /**
     * Executes the user registration process.
     *
     * @param RegisterUserRequest $request The registration request data
     * @return UserResponseDTO Data transfer object with the new user's information
     * @throws UserAlreadyExistsException When the email is already in use
     */
    public function execute(RegisterUserRequest $request): UserResponseDTO
    {
        $email = Email::fromString($request->email());

        // Check if email is already in use
        if ($this->userRepository->findByEmail($email)) {
            throw new UserAlreadyExistsException('Email already in use');
        }

        // Create a new user
        $user = User::register(
            UserId::generate(),
            Name::fromString($request->name()),
            $email,
            Password::fromPlainPassword($request->password())
        );

        // Save the user
        $this->userRepository->save($user);

        // Dispatch events
        foreach ($user->releaseEvents() as $event) {
            $this->eventDispatcher->dispatch($event);
        }

        // Return response DTO
        return new UserResponseDTO(
            $user->id()->value(),
            $user->name()->value(),
            $user->email()->value(),
            $user->createdAt()->format('Y-m-d H:i:s')
        );
    }
}
