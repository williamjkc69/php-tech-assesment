<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMSetup;
use Infrastructure\Persistence\Doctrine\DoctrineUserRepository;

// Setup Doctrine
$paths = [__DIR__ . '/../src/Domain/Model'];
$isDevMode = env('APP_ENV') === 'development';

$config = ORMSetup::createAttributeMetadataConfiguration($paths, $isDevMode);

$connectionParams = [
    'driver' => config('db.driver'),
    'host' => config('db.host_test'),
    'dbname' => config('db.dbname_test'),
    'user' => config('db.user_test'),
    'password' => config('db.password_test'),
    'charset' => config('db.charset')
];

$conn = DriverManager::getConnection($connectionParams, $config);
$entityManager = new EntityManager($conn, $config);

// Create db schema
$schemaTool = new \Doctrine\ORM\Tools\SchemaTool($entityManager);
$metadata = $entityManager->getMetadataFactory()->getAllMetadata();

// check if schema exists
$schemaManager = $entityManager->getConnection()->getSchemaManager();
$tables = $schemaManager->listTableNames();


try {
    if (empty($tables)) {
        $schemaTool->createSchema($metadata);
    } else {
        $schemaTool->updateSchema($metadata);
    }
} catch (\Exception $e) {
    die("Error creating database schema: " . $e->getMessage());
}



// Setup repositories
$userRepository = new DoctrineUserRepository($entityManager);

return $entityManager;
