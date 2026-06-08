<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

require_once "../connection.php";

// Get inputs
$name        = trim($_POST['name'] ?? '');
$category_id = intval($_POST['category_id'] ?? 0);
$slug        = trim($_POST['slug'] ?? '');
$image       = $_POST['image'] ?? null; // Cloudinary URL from frontend

// Validation
if (!$name || $category_id <= 0 || !$slug) {
    http_response_code(400);
    echo json_encode([
        "success" => false,
        "message" => "name, category_id, and slug are required"
    ]);
    exit;
}

// Check for duplicate slug
$checkSql  = "SELECT id FROM subcategories WHERE slug = ?";
$checkStmt = mysqli_prepare($conn, $checkSql);
mysqli_stmt_bind_param($checkStmt, "s", $slug);
mysqli_stmt_execute($checkStmt);
mysqli_stmt_store_result($checkStmt);

if (mysqli_stmt_num_rows($checkStmt) > 0) {
    http_response_code(409);
    echo json_encode([
        "success" => false,
        "message" => "Slug already exists"
    ]);
    mysqli_stmt_close($checkStmt);
    exit;
}
mysqli_stmt_close($checkStmt);

// Insert query (with image)
$sql  = "INSERT INTO subcategories (name, slug, category_id, image) VALUES (?, ?, ?, ?)";
$stmt = mysqli_prepare($conn, $sql);

if (!$stmt) {
    http_response_code(500);
    echo json_encode([
        "success" => false,
        "message" => mysqli_error($conn)
    ]);
    exit;
}

mysqli_stmt_bind_param($stmt, "ssis", $name, $slug, $category_id, $image);

try {
    mysqli_stmt_execute($stmt);
    echo json_encode([
        "success" => true,
        "message" => "Subcategory created successfully",
        "id"      => mysqli_insert_id($conn)
    ]);
} catch (mysqli_sql_exception $e) {
    http_response_code(500);
    echo json_encode([
        "success" => false,
        "message" => $e->getMessage()
    ]);
}

mysqli_stmt_close($stmt);
mysqli_close($conn);