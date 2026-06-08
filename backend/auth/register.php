<?php

header("access-control-allow-origin:*");
header("access-control-allow-Headers: Content-Type");
header("Content-Type: application/json");
header("access-control-allow-methods: POST, OPTIONS");
header("Access-Control-Allow-Methods: POST, OPTIONS");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS'){
    http_response_code(200);
    exit;
}


// require_once "../connection.php";
include("../public/connection.php");

$data = json_decode(file_get_contents("php://input"), true);

if (
    !isset($data['name']) ||
    !isset($data['email']) ||
    !isset($data['phone']) ||
    !isset($data['password'])
) {
    http_response_code(400);
    echo json_encode(["error" => "All fields are required"]);
    exit;
}

$name = $data['name'];
$email = $data['email'];
$phone = $data['phone'];
$password = password_hash($data['password'], PASSWORD_DEFAULT);
$role = "user"; // force default role

// Check if email exists
$checkSql = "SELECT id FROM users WHERE email = ?";

$checkStmt = mysqli_prepare($conn, $checkSql);

mysqli_stmt_bind_param($checkStmt, "s", $email);

mysqli_stmt_execute($checkStmt);

$result = mysqli_stmt_get_result($checkStmt);

if (mysqli_fetch_assoc($result)) {
    http_response_code(409);
    echo json_encode(["error" => "Email already exists"]);
    exit;
}

// Insert user
$sql = "INSERT INTO users (name, email, phone, password, role) VALUES (?, ?, ?, ?, ?)";

$stmt = mysqli_prepare($conn, $sql);

mysqli_stmt_bind_param($stmt, "sssss", $name, $email, $phone, $password, $role);
mysqli_stmt_execute($stmt);

echo json_encode([
    "success" => true,
    "message" => "User registered successfully"
]);
