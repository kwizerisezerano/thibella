<?php

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../core/Response.php';

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

$config = require __DIR__ . '/../config/jwt.php';

$authHeader = $_SERVER['HTTP_AUTHORIZATION']
    ?? $_SERVER['REDIRECT_HTTP_AUTHORIZATION']
    ?? (getallheaders()['Authorization'] ?? null)
    ?? (getallheaders()['authorization'] ?? null);

if (!$authHeader) {
    Response::error('Authorization header missing', 401);
}

$token = str_replace('Bearer ', '', $authHeader);

try {
    $decoded  = JWT::decode($token, new Key($config['secret_key'], 'HS256'));
    $authUser = ['id' => $decoded->user_id, 'role' => $decoded->role];
} catch (Exception $e) {
    Response::error('Invalid or expired token', 401);
}
