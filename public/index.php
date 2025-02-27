<?php

// helpers
require __DIR__ . '/../app/helpers.php';

// Load bootstrap
$container = require __DIR__ . '/../config/bootstrap.php';

// Get request data
$requestMethod = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

header('Content-Type: application/json');

// Parse JSON request body
$requestData = [];
if ($requestMethod === 'POST') {
    $requestBody = file_get_contents('php://input');
    $requestData = json_decode($requestBody, true) ?? [];
}

// Simple router
if ($requestMethod === 'POST' && $uri === '/register') {
    $controller = $container['registerUserController'];
    echo $controller->register($requestData);
} else {
    http_response_code(404);
    echo json_encode(['status' => 'error', 'message' => 'Not found']);
}
