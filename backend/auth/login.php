<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");
header("Access-Control-Allow-Methods: POST, OPTIONS");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS'){
    http_response_code(200);
    exit;
}

require_once "../public/connection.php";
require_once "../vendor/autoload.php";

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

$config = require "../config/jwt.php";

$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data['email'], $data['password'])) {
    http_response_code(400);
    echo json_encode(["error" => "Email and password required"]);
    exit;
}

$email = $data['email'];
$password = $data['password'];

// ✅ Also fetch name so frontend can display it
$sql = "SELECT id, name, password, role FROM users WHERE email = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "s", $email);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$user = mysqli_fetch_assoc($result);

if (!$user || !password_verify($password, $user['password'])) {
    http_response_code(401);
    echo json_encode(["error" => "Invalid credentials"]);
    exit;
}

// Create token payload
$payload = [
    "iss"     => $config['issuer'],
    "aud"     => $config['audience'],
    "iat"     => time(),
    "exp"     => time() + $config['expiry'],
    "user_id" => $user['id'],
    "role"    => $user['role']
];

// Generate JWT
$jwt = JWT::encode($payload, $config['secret_key'], 'HS256');

// ✅ Return userId and name so frontend can store and use them
echo json_encode([
    "success" => true,
    "message" => "Login successful",
    "token"   => $jwt,
    "userId"  => $user['id'],   // ✅ was missing
    "name"    => $user['name'], // ✅ was missing
    "role"    => $user['role'],
]);