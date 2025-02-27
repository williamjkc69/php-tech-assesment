<?php

namespace Presentation\Controller;

use Application\UseCase\RegisterUser\RegisterUserUseCase;
use Application\UseCase\RegisterUser\RegisterUserRequest;
use Domain\Exception\InvalidEmailException;
use Domain\Exception\WeakPasswordException;
use Domain\Exception\UserAlreadyExistsException;

class RegisterUserController
{
    private RegisterUserUseCase $registerUserUseCase;

    /**
     * Constructor for RegisterUserController.
     *
     * @param RegisterUserUseCase $registerUserUseCase The use case for registering a user.
     */
    public function __construct(RegisterUserUseCase $registerUserUseCase)
    {
        $this->registerUserUseCase = $registerUserUseCase;
    }

    /**
     * Handles the user registration request.
     *
     * Validates the request data, creates a RegisterUserRequest DTO, and executes the use case.
     * Returns a JSON response indicating success or failure.
     *
     * @param array $requestData The request data containing name, email, and password.
     * @return string A JSON-encoded response indicating success or failure.
     */
    public function register(array $requestData): string
    {
        try {
            // Validate request data
            if (!isset($requestData['name']) || !isset($requestData['email']) || !isset($requestData['password'])) {
                return $this->errorResponse('Missing required fields', 400);
            }

            // Create request DTO
            $request = new RegisterUserRequest(
                $requestData['name'],
                $requestData['email'],
                $requestData['password']
            );

            // Execute use case
            $response = $this->registerUserUseCase->execute($request);

            // Return success response
            return json_encode([
                'status' => 'success',
                'data' => $response->toArray()
            ]);

        } catch (InvalidEmailException $e) {
            return $this->errorResponse('Invalid email: ' . $e->getMessage(), 400);
        } catch (WeakPasswordException $e) {
            return $this->errorResponse('Weak password: ' . $e->getMessage(), 400);
        } catch (UserAlreadyExistsException $e) {
            return $this->errorResponse('User already exists: ' . $e->getMessage(), 409);
        } catch (\InvalidArgumentException $e) {
            return $this->errorResponse('Invalid input: ' . $e->getMessage(), 400);
        } catch (\Exception $e) {
            return $this->errorResponse('Server error: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Generates an error response in JSON format.
     *
     * @param string $message The error message.
     * @param int $code The HTTP status code.
     * @return string A JSON-encoded error response.
     */
    private function errorResponse(string $message, int $code): string
    {
        http_response_code($code);
        return json_encode([
            'status' => 'error',
            'message' => $message
        ]);
    }
}
