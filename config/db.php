<?php

return [
    'driver' => 'pdo_mysql',
    'host' => 'db',
    'dbname' => env('MYSQL_DATABASE', 'app_db'),
    'user' => env('MYSQL_USER', 'app_user'),
    'password' =>   env('MYSQL_PASSWORD'),
    'charset' => 'utf8mb4'
];
