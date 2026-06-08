<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");
header("Access-Control-Allow-Methods: POST, OPTIONS");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
  http_response_code(200);
  exit;
}

require_once "../connection.php";


$title = $_POST['title'];
$description = $_POST['description'] ?? '';
$slug = $_POST['slug'];
$image = $_POST['image'] ?? null;

//var_dump($title, $description, $slug, $image);

$sql = "INSERT INTO categories (title, description, slug, image)
        VALUES (?, ?, ?, ?)";

$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "ssss", $title, $description, $slug, $image);

try {
  mysqli_stmt_execute($stmt);
  echo json_encode(["success" => true, "message" => "Category created"]);
} catch (mysqli_sql_exception $e) {
  http_response_code(500);
  echo json_encode(["success" => false, "error" => $e->getMessage()]);
}

mysqli_stmt_close($stmt);
mysqli_close($conn);