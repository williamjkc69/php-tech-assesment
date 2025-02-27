# PHP Challenge (User Registration Application)

This repository contains a PHP application built without frameworks (except Doctrine ORM) that demonstrates Domain-Driven Design (DDD), Clean Architecture, and SOLID principles. The application handles user registration with proper validation, persistence, and event handling.

## Features

- Domain-Driven Design with properly structured layers
- Value Objects for entity attributes validation
- Repository pattern with Doctrine ORM
- Domain Events for handling side effects
- Unit and Integration Tests with PHPUnit
- Docker-based development environment

## Requirements

- Docker and Docker Compose
- Git
- Make (optional, but recommended)

## Project Structure

```
/app
/src
  /Domain               # Core business logic, entities, value objects
    /Model
      /User
      /Event
    /Repository
    /Exception
  /Application          # Use cases and application services
    /UseCase
    /DTO
    /Event
  /Infrastructure       # Implementation of interfaces defined in domain
    /Persistence
    /Event
  /Presentation         # Controllers and API endpoints
    /Controller
/tests                  # Automated tests
  /Unit
  /Integration
/public                # Public folder
  index.php
/config                 # Configuration files
/nginx                 # Server configuration
docker-compose.yml      # Docker configuration
Dockerfile              # PHP environment setup
Makefile                # Helper commands
```

## Installation

1. Clone the repository:

```bash
git clone https://github.com/williamjkc69/php-tech-assessment.git
cd php-tech-assessment
```

2. Create a `.env` file in the root directory:

```
APP_ENV=development

# Database
MYSQL_DATABASE=user_db
MYSQL_ROOT_PASSWORD=password
MYSQL_USER=app_user
MYSQL_PASSWORD=app_password
```

3. Build and start the Docker containers:

```bash
make up
# or
docker-compose up -d
```

4. Install dependencies and set up the database:

```bash
make setup
# or
docker-compose exec app composer install
docker-compose exec app php vendor/bin/doctrine orm:schema-tool:create
```

## Usage

### Register a New User

You can register a new user by sending a POST request to the `/register` endpoint:

```bash
curl -X POST http://localhost:8080/register \
  -H "Content-Type: application/json" \
  -d '{"name":"John Doe","email":"john@example.com","password":"StrongP@ss1"}'
```

A successful response looks like:

```json
{
  "status": "success",
  "data": {
    "id": "user_65dbc7e8a1234",
    "name": "John Doe",
    "email": "john@example.com",
    "createdAt": "2025-02-26 15:30:00"
  }
}
```

## Running the Tests

Run the PHPUnit tests:

```bash
make test
# or
docker-compose exec app php vendor/bin/phpunit
```

## Available Make Commands

- `make up`: Start Docker containers
- `make down`: Stop Docker containers
- `make setup`: Install dependencies and set up database
- `make test`: Run PHPUnit tests

## Technical Implementation Details

### Domain Layer

- **User Entity**: Immutable entity with proper validation
- **Value Objects**: UserId, Email, Name, Password with validation
- **Domain Events**: UserRegisteredEvent for handling side effects
- **Repository Interface**: Defines persistence operations

### Application Layer

- **RegisterUserUseCase**: Coordinates the registration process
- **DTOs**: For input/output data transformation
- **Event Dispatcher Interface**: For handling domain events

### Infrastructure Layer

- **DoctrineUserRepository**: Implements persistence with Doctrine ORM
- **SimpleEventDispatcher**: Implements event handling
- **UserRegisteredEmailSender**: Listens for registration events

### Presentation Layer

- **RegisterUserController**: Handles HTTP requests and responses

## Security Considerations

- Passwords are hashed using BCrypt
- Input validation for email, name, and password
- Security exceptions for invalid input
- Email uniqueness validation

## Testing

The application includes both unit and integration tests:

- Unit tests for entities and value objects
- Unit tests for use cases
- Integration tests for repository implementations

\
\
*William Urbina*
*willliamjkc69@gmail.com*