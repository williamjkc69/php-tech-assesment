<?php

// cli-config.php
use Doctrine\ORM\Tools\Console\ConsoleRunner;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMSetup;
use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\Tools\Console\EntityManagerProvider\SingleManagerProvider;

require_once 'bootstrap.php';

// Load Doctrine configuration
$paths = [__DIR__ . '/../src/Domain/Model']; // Path to your entities
$isDevMode = env('APP_ENV') === 'development';

$config = ORMSetup::createAttributeMetadataConfiguration($paths, $isDevMode);

// Database connection parameters
$connectionParams = [
    'driver' => config('db.driver'),
    'host' => config('db.host'),
    'dbname' => config('db.dbname'),
    'user' => config('db.user'),
    'password' => config('db.password'),
    'charset' => config('db.charset')
];

// Create the EntityManager
$conn = DriverManager::getConnection($connectionParams, $config);
$entityManager = new EntityManager($conn, $config);

$commands = [
    // If you want to add your own custom console commands,
    // you can do so here.
];

// Return the EntityManager for Doctrine CLI tools
return ConsoleRunner::run(new SingleManagerProvider($entityManager), $commands);
