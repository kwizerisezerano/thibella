<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Content-Type: application/json");
header("Access-Control-Allow-Methods: POST, OPTIONS");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
  http_response_code(200);
  exit;
}

require_once "../../middleware/admin.php";
require_once "../connection.php";

// ─── Read & validate inputs ───────────────────────────────────────────────────

$productName        = trim($_POST['productName']   ?? '');
$description        = trim($_POST['description']   ?? '');
$price              = (float) ($_POST['price'] ?? 0);
$isOnSale           = intval($_POST['isOnSale']    ?? 0);   // 0 or 1
$category_id        = intval($_POST['category_id'] ?? 0);
$subCategory_id     = intval($_POST['subCategory_id'] ?? 0);// ✅ FK integer (0 means null)
$imageUrl           = trim($_POST['imageUrl']      ?? '');
$brand              = trim($_POST['brand']         ?? '');
$stock              = intval($_POST['stock']       ?? 0);
$currency           = trim($_POST['currency']      ?? 'RWF');

// These arrive as JSON strings from the frontend (JSON.stringify)
$sizeRaw            = $_POST['size']               ?? '[]';
$colorRaw           = $_POST['color']              ?? '[]';
$possibleImagesRaw  = $_POST['possibleImagesUrls'] ?? '[]';

// Validate that they are proper JSON before storing
$size              = json_decode($sizeRaw)             !== null ? $sizeRaw             : trim((string)$sizeRaw);
$color             = json_decode($colorRaw)            !== null ? $colorRaw            : trim((string)$colorRaw);
$possibleImagesUrls = json_decode($possibleImagesRaw)  !== null ? $possibleImagesRaw   : '[]';

// Basic required-field check
if (!$productName  || $category_id <= 0) {
  http_response_code(400);
  echo json_encode([
    "success" => false,
    "message" => "Missing required fields: productName and category_id are required."
  ]);
  exit;
}

$subCategory_id = $subCategory_id > 0 ? $subCategory_id : null;

// Check if product with same name already exists in same category
$checkStmt = mysqli_prepare($conn, "SELECT id FROM products WHERE productName = ? AND category_id = ? LIMIT 1");
mysqli_stmt_bind_param($checkStmt, "si", $productName, $category_id);
mysqli_stmt_execute($checkStmt);
mysqli_stmt_store_result($checkStmt);
if (mysqli_stmt_num_rows($checkStmt) > 0) {
  http_response_code(409);
  echo json_encode([
    "success" => false,
    "message" => "Product with this name already exists in the same category"
  ]);
  mysqli_stmt_close($checkStmt);
  mysqli_close($conn);
  exit;
}
mysqli_stmt_close($checkStmt);

// ─── Insert product ───────────────────────────────────────────────────────────
// ✅ Column name matches DB schema: category_id (not categoryId)
$sql = "
  INSERT INTO products
    (productName, description, price, size, color, isOnSale, imageUrl, possibleImagesUrls, brand, stock, category_id, subCategory_id, currency)
  VALUES
    (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
";

$stmt = mysqli_prepare($conn, $sql);

if (!$stmt) {
  http_response_code(500);
  echo json_encode([
    "success" => false,
    "message" => "Failed to prepare statement: " . mysqli_error($conn)
  ]);
  exit;
}

// ✅ Bind types:
mysqli_stmt_bind_param(
  $stmt,
  "ssdssisssiiis",
  $productName,
  $description,
  $price,
  $size,
  $color,
  $isOnSale,
  $imageUrl,
  $possibleImagesUrls,
  $brand,
  $stock,
  $category_id,
  $subCategory_id,
  $currency
);

try {
  mysqli_stmt_execute($stmt);

  echo json_encode([
    "success"    => true,
    "message"    => "Product added successfully",
    "product_id" => mysqli_insert_id($conn)
  ]);

} catch (mysqli_sql_exception $e) {
  http_response_code(500);
  echo json_encode([
    "success" => false,
    "error"   => "Failed to add product",
    "message" => $e->getMessage()
  ]);
}

mysqli_stmt_close($stmt);
mysqli_close($conn);
