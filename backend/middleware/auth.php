<?php

// require_once "../vendor/autoload.php";
// require_once "../vendor/autoload.php";
require_once __DIR__ . '/../vendor/autoload.php';


use Firebase\JWT\JWT;
use Firebase\JWT\Key;

// $config = require "../config/jwt.php";
$config = require_once __DIR__ . '/../config/jwt.php';


$authHeader = null;

if (isset($_SERVER['HTTP_AUTHORIZATION'])){
     $authHeader = $_SERVER['HTTP_AUTHORIZATION'];
} else if (isset($_SERVER['REDIRECT_HTTP_AUTHORIZATION'])){
     $authHeader = $_SERVER['REDIRECT_HTTP_AUTHORIZATION'];
} else {
        $headers = getallheaders();
        if (isset($headers['Authorization'])){
            $authHeader = $headers['Authorization'];
        } else if (isset($headers['authorization'])){
            $authHeader = $headers['authorization'];
        }
}

$token = str_replace("Bearer ", "", $authHeader);

try {
    $decoded = JWT::decode($token, new Key($config['secret_key'], 'HS256'));

    $authUser = [
    "id" => $decoded->user_id,
    "role" => $decoded->role
    ];

} catch (Exception $e) {
    http_response_code(401);
    echo json_encode(["error" => "Invalid or expired token"]);
    exit;
}
