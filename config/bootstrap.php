<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMSetup;
use Infrastructure\Persistence\Doctrine\DoctrineUserRepository;
use Infrastructure\Event\SimpleEventDispatcher;
use Infrastructure\Event\UserRegisteredEmailSender;
use Application\UseCase\RegisterUser\RegisterUserUseCase;
use Presentation\Controller\RegisterUserController;
use Domain\Model\Event\UserRegisteredEvent;

// Setup Doctrine
$paths = [__DIR__ . '/../src/Infrastructure/Persistence/Doctrine/Mapping'];
$isDevMode = true;

$config = ORMSetup::createAttributeMetadataConfiguration($paths, $isDevMode);

$connectionParams = [
    'driver' => config('db.driver'),
    'host' => config('db.host'),
    'dbname' => config('db.dbname'),
    'user' => config('db.user'),
    'password' => config('db.password'),
    'charset' => config('db.charset')
];

$conn = DriverManager::getConnection($connectionParams, $config);
$entityManager = new EntityManager($conn, $config);

// Setup repositories
$userRepository = new DoctrineUserRepository($entityManager);

// Setup event system
$eventDispatcher = new SimpleEventDispatcher();
$eventDispatcher->addListener(UserRegisteredEvent::class, new UserRegisteredEmailSender());

// Setup use cases
$registerUserUseCase = new RegisterUserUseCase($userRepository, $eventDispatcher);

// Setup controllers
$registerUserController = new RegisterUserController($registerUserUseCase);

return [
    'entityManager' => $entityManager,
    'userRepository' => $userRepository,
    'eventDispatcher' => $eventDispatcher,
    'registerUserUseCase' => $registerUserUseCase,
    'registerUserController' => $registerUserController,
];
