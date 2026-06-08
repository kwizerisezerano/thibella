<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");
header("Access-Control-Allow-Methods: POST, OPTIONS");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
  http_response_code(200);
  exit;
}

require_once "../connection.php";

// Get ID from URL param
$id = $_GET['id'] ?? null;

if (!$id) {
  http_response_code(400);
  echo json_encode([
    "success" => false,
    "message" => "ID is required in URL"
  ]);
  exit;
}

// Required fields validation
$requiredFields = [
    'title', 'description', 'slug', 'image'
];

foreach ($requiredFields as $field) {
    if (!isset($_POST[$field])) {
        http_response_code(400);
        echo json_encode([
            "success" => false,
            "error" => "$field is required"
        ]);
        exit;
    }
}

// Get POST data
$title = $_POST['title'];
$description = $_POST['description'];
$slug = $_POST['slug'];
$image = $_POST['image'];


$sql = "UPDATE categories 
        SET title = ?, description = ?, slug = ?, image = ?
        WHERE id = ?";

$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "ssssi", $title, $description, $slug, $image, $id);

try {

  mysqli_stmt_execute($stmt);

  if (mysqli_stmt_affected_rows($stmt) > 0) {
    echo json_encode([
      "success" => true,
      "message" => "Category updated"
    ]);
  } else {
    http_response_code(404);
    echo json_encode([
      "success" => false,
      "message" => "Category not found or no changes made"
    ]);
  }

} catch (mysqli_sql_exception $e) {

  http_response_code(500);
  echo json_encode([
    "success" => false,
    "error" => $e->getMessage()
  ]);
}

mysqli_stmt_close($stmt);
mysqli_close($conn);