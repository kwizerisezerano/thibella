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
$priceCents         = intval($_POST['priceCents']  ?? 0);
$type               = trim($_POST['type']          ?? '');
$isOnSale           = intval($_POST['isOnSale']    ?? 0);   // 0 or 1
$category_id        = intval($_POST['category_id'] ?? 0);
$subCategory_id = intval($_POST['subCategory_id'] ?? 0);// ✅ FK integer
//$subcategory		= trim($_POST['subCategory_id']   ?? '';
$imageUrl           = trim($_POST['imageUrl']      ?? '');

// These arrive as JSON strings from the frontend (JSON.stringify)
$sizeRaw            = $_POST['size']               ?? '[]';
$colorRaw           = $_POST['color']              ?? '[]';
$possibleImagesRaw  = $_POST['possibleImagesUrls'] ?? '[]';

// Validate that they are proper JSON before storing
$size              = json_decode($sizeRaw)             !== null ? $sizeRaw             : '[]';
$color             = json_decode($colorRaw)            !== null ? $colorRaw            : '[]';
$possibleImagesUrls = json_decode($possibleImagesRaw)  !== null ? $possibleImagesRaw   : '[]';

// Basic required-field check
if (!$productName  || $category_id <= 0) {
    http_response_code(400);
    echo json_encode([
        "success" => false,
        "message" => "Missing required fields: productName, description, priceCents, and category_id are required."
    ]);
    exit;
}

// ─── Insert product ───────────────────────────────────────────────────────────
// ✅ Column name matches DB schema: category_id (not categoryId)
$sql = "
    INSERT INTO products
        (productName, description, priceCents, size, color, type, isOnSale, imageUrl, possibleImagesUrls, category_id, subCategory_id)
    VALUES
        (?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?)
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
//   s = productName      (string)
//   s = description      (string)
//   i = priceCents       (integer)
//   s = size             (JSON string)
//   s = color            (JSON string)
//   s = type             (string)
//   i = isOnSale         (integer / tinyint)
//   s = imageUrl         (string)
//   s = possibleImagesUrls (JSON string / longtext)
//   i = category_id      (integer FK)
mysqli_stmt_bind_param(
    $stmt,
    "ssississsii",
    $productName,
    $description,
    $priceCents,
    $size,
    $color,
    $type,
    $isOnSale,
    $imageUrl,
    $possibleImagesUrls,
    $category_id,
    $subCategory_id
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