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

    public function __construct(RegisterUserUseCase $registerUserUseCase)
    {
        $this->registerUserUseCase = $registerUserUseCase;
    }

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

    private function errorResponse(string $message, int $code): string
    {
        http_response_code($code);
        return json_encode([
            'status' => 'error',
            'message' => $message
        ]);
    }
}
