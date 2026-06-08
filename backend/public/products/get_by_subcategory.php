<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
header("Access-Control-Allow-Methods: GET");
require_once "../connection.php";

// Get input
$subcategory_id = intval($_GET['subcategory_id'] ?? 0);

// Validation
if ($subcategory_id <= 0) {
    http_response_code(400);
    echo json_encode([
        "success" => false,
        "message" => "subcategory_id is required"
    ]);
    exit;
}

// Query
$sql = "SELECT * FROM products WHERE subCategory_id = ?";
$stmt = mysqli_prepare($conn, $sql);

if (!$stmt) {
    http_response_code(500);
    echo json_encode([
        "success" => false,
        "message" => mysqli_error($conn)
    ]);
    exit;
}

mysqli_stmt_bind_param($stmt, "i", $subcategory_id);
mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);
$products = [];

while ($row = mysqli_fetch_assoc($result)) {
    // Decode JSON fields
    $row['size'] = json_decode($row['size']);
    $row['color'] = json_decode($row['color']);
    $products[] = $row;
}

if (empty($products)) {
    echo json_encode([
        "success" => false,
        "message" => "No products found for this subcategory"
    ]);
    exit;
}

echo json_encode([
    "success" => true,
  	"subcategory_name" => $subcategory_name, // add this line
    "count" => count($products),
    "products" => $products
]);

mysqli_stmt_close($stmt);
mysqli_close($conn);