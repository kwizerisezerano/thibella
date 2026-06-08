<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");
header("Access-Control-Allow-Methods: DELETE, OPTIONS");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
  http_response_code(200);
  exit;
}

require_once "../connection.php";

// Get ID from URL param
$id = isset($_GET['id']) ? (int) $_GET['id'] : null;

if (!$id) {
  http_response_code(400);
  echo json_encode([
    "success" => false,
    "message" => "ID is required in URL"
  ]);
  exit;
}

$sql = "DELETE FROM categories WHERE id = ?";

try {

  $stmt = mysqli_prepare($conn, $sql);
  mysqli_stmt_bind_param($stmt, "i", $id);
  mysqli_stmt_execute($stmt);

  if (mysqli_stmt_affected_rows($stmt) > 0) {
    http_response_code(200);
    echo json_encode([
      "success" => true,
      "message" => "Category deleted successfully"
    ]);
  } else {
    http_response_code(404);
    echo json_encode([
      "success" => false,
      "message" => "Category not found"
    ]);
  }

} catch (mysqli_sql_exception $e) {

  http_response_code(500);
  echo json_encode([
    "success" => false,
    "error" => $e->getMessage()
  ]);

} finally {

  if (isset($stmt)) {
    mysqli_stmt_close($stmt);
  }

  mysqli_close($conn);
}