<?php

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

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

// Required fields validation
$requiredFields = [
    'productName', 'description', 'priceCents',
    'type', 'isOnSale', 'category_id','imageUrl'
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

error_log(print_r($_POST, true));

// Get POST data
$productName = $_POST['productName'];
$description = $_POST['description'];
$priceCents = (int) $_POST['priceCents'];
$type = $_POST['type'];
$isOnSale =  (int) $_POST['isOnSale'];
$category = $_POST['category'];
$category_id = (int) $_POST['category_id'];
$subCategory_id = (int) $_POST['subCategory_id'];
$imageUrl = $_POST['imageUrl'];

// Encode arrays safely
$size = $_POST['size'] ?? [];
$color = $_POST['color'] ?? [];
$possibleImagesUrls = $_POST['possibleImagesUrls'] ?? [];

$sql = "
UPDATE products SET
  productName = ?,
  description = ?,
  priceCents = ?,
  size = ?,
  color = ?,
  type = ?,
  isOnSale = ?,
  category = ?,
  category_id = ?, 
  subCategory_id = ?,
  imageUrl = ?,
  possibleImagesUrls = ?
WHERE id = ?
";

try {
    $stmt = mysqli_prepare($conn, $sql);

    mysqli_stmt_bind_param(
        $stmt,
        "ssisssisiissi",
        $productName,
        $description,
        $priceCents,
        $size,
        $color,
        $type,
        $isOnSale,
        $category,
       	$category_id,
      	$subCategory_id,
        $imageUrl,
        $possibleImagesUrls,
        $productId
    );

    mysqli_stmt_execute($stmt);

    http_response_code(200);
    echo json_encode([
        "success" => true,
        "message" => "Product updated successfully"
    ]);

} catch (mysqli_sql_exception $e) {

    http_response_code(500);
    echo json_encode([
        "success" => false,
        "error" => "Failed to update product",
        "message" => $e->getMessage() //i will hide this in production
    ]);

} finally {

    if (isset($stmt)) {
        mysqli_stmt_close($stmt);
    }

    if (isset($conn)) {
        mysqli_close($conn);
    }
}
