<?php

return [
    'driver' => 'pdo_mysql',
    'host' => 'db',
    'dbname' => env('MYSQL_DATABASE', 'app_db'),
    'user' => env('MYSQL_USER', 'app_user'),
    'password' =>   env('MYSQL_PASSWORD'),
    'charset' => 'utf8mb4',

    'host_test' => 'db_test',
    'dbname_test' => env('MYSQL_DATABASE_TEST', 'test_db'),
    'user_test' => env('MYSQL_USER_TEST', 'test_user'),
    'password_test' =>   env('MYSQL_PASSWORD_TEST', 'test_password'),
];
