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
$isDevMode = true;

$config = ORMSetup::createAttributeMetadataConfiguration($paths, $isDevMode);

// Database connection parameters
$connectionParams = [
    'driver' => 'pdo_mysql',
    'host' => 'db',
    'dbname' => 'user_db',
    'user' => 'app_user',
    'password' => 'app_password',
    'charset' => 'utf8mb4'
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
