<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Content-Type: application/json");
header("Access-Control-Allow-Methods: POST, OPTIONS");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS'){
    http_response_code(200);
    exit;
}

require_once "../../middleware/admin.php";
require_once "../connection.php";

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);


// Accept ID from GET or POST
$productId = $_GET['id'] ?? $_POST['id'] ?? null;

if (!$productId) {
    http_response_code(400);
    echo json_encode([
        "success" => false,
        "error" => "Product ID is required"
    ]);
    exit;
}

// DELETE query
$sql = "DELETE FROM products WHERE id = ?";

$stmt = mysqli_prepare($conn, $sql);

// Bind parameter 
mysqli_stmt_bind_param($stmt, "i", $productId);

try {
    // Execute statement
    mysqli_stmt_execute($stmt);

    // 5 if a row was actually deleted
    if (mysqli_stmt_affected_rows($stmt) === 0) {
        http_response_code(404);
        echo json_encode([
            "success" => false,
            "message" => "Product not found"
        ]);
    } else {
        echo json_encode([
            "success" => true,
            "message" => "Product deleted successfully"
        ]);
    }

} catch (mysqli_sql_exception $e) {
    http_response_code(500);
    echo json_encode([
        "success" => false,
        "error" => "Failed to delete product",
        "message" => $e->getMessage()
    ]);
} finally {

    if (isset($stmt)) {
        mysqli_stmt_close($stmt);
    }

    if (isset($conn)) {
        mysqli_close($conn);
    }
}

