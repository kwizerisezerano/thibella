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
    'productName', 'category_id'
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
$productName    = trim((string)($_POST['productName'] ?? ''));
$description    = trim((string)($_POST['description'] ?? ''));
$price          = (float) ($_POST['price'] ?? 0);
$isOnSale       = (int) ($_POST['isOnSale'] ?? 0);
$category_id    = (int) ($_POST['category_id'] ?? 0);
$subCategory_id = (int) ($_POST['subCategory_id'] ?? 0);
$imageUrl       = trim((string)($_POST['imageUrl'] ?? ''));
$brand          = trim((string)($_POST['brand'] ?? ''));
$stock          = (int) ($_POST['stock'] ?? 0);
$currency       = trim((string)($_POST['currency'] ?? 'RWF'));

if ($productName === '' || $category_id <= 0) {
    http_response_code(400);
    echo json_encode([
        "success" => false,
        "error" => "productName and category_id are required"
    ]);
    exit;
}

$subCategory_id = $subCategory_id > 0 ? $subCategory_id : null;

$sizeRaw           = $_POST['size'] ?? '';
$colorRaw          = $_POST['color'] ?? '';
$possibleImagesRaw = $_POST['possibleImagesUrls'] ?? '[]';

$size              = json_decode((string)$sizeRaw) !== null ? (string)$sizeRaw : trim((string)$sizeRaw);
$color             = json_decode((string)$colorRaw) !== null ? (string)$colorRaw : trim((string)$colorRaw);
$possibleImagesUrls = json_decode((string)$possibleImagesRaw) !== null ? (string)$possibleImagesRaw : '[]';

$sql = "
UPDATE products SET
  productName = ?,
  description = ?,
  price = ?,
  size = ?,
  color = ?,
  isOnSale = ?,
  category_id = ?, 
  subCategory_id = ?,
  imageUrl = ?,
  possibleImagesUrls = ?,
  brand = ?,
  stock = ?,
  currency = ?
WHERE id = ?
";

try {
    $stmt = mysqli_prepare($conn, $sql);

    mysqli_stmt_bind_param(
        $stmt,
        "ssdssiiisssisi",
        $productName,
        $description,
        $price,
        $size,
        $color,
        $isOnSale,
        $category_id,
        $subCategory_id,
        $imageUrl,
        $possibleImagesUrls,
        $brand,
        $stock,
        $currency,
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
