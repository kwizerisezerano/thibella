<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");
header("Access-Control-Allow-Methods: GET, OPTIONS");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

require_once "../connection.php";

    
// CHECK IF SLUG EXISTS

if (!isset($_GET['slug'])) {
    http_response_code(400);
    echo json_encode([
        "success" => false,
        "message" => "Slug parameter is required"
    ]);
    exit;
}

$slug = $_GET['slug'];



// PAGINATION PARAMETERS

$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
$limit = isset($_GET['limit']) ? (int) $_GET['limit'] : 20;

if ($page < 1) $page = 1;
if ($limit < 1) $limit = 20;

$offset = ($page - 1) * $limit;



// GET CATEGORY BY SLUG

$stmt = mysqli_prepare($conn, "SELECT * FROM categories WHERE slug = ?");
mysqli_stmt_bind_param($stmt, "s", $slug);
mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);
$category = mysqli_fetch_assoc($result);

mysqli_stmt_close($stmt);

if (!$category) {
    http_response_code(404);
    echo json_encode([
        "success" => false,
        "message" => "Category not found"
    ]);
    exit;
}

$categoryId = $category['id'];



// GET TOTAL PRODUCTS (FOR PAGINATION)

$stmt = mysqli_prepare($conn, "SELECT COUNT(*) as total FROM products WHERE category_id = ?");
mysqli_stmt_bind_param($stmt, "i", $categoryId);
mysqli_stmt_execute($stmt);

$resultTotal = mysqli_stmt_get_result($stmt);
$totalRow = mysqli_fetch_assoc($resultTotal);
$totalProducts = $totalRow['total'];

mysqli_stmt_close($stmt);



// GET PAGINATED PRODUCTS

$stmt = mysqli_prepare($conn, "SELECT * FROM products WHERE category_id = ? LIMIT ? OFFSET ?");
mysqli_stmt_bind_param($stmt, "iii", $categoryId, $limit, $offset);
mysqli_stmt_execute($stmt);

$resultProducts = mysqli_stmt_get_result($stmt);

$products = [];

while ($row = mysqli_fetch_assoc($resultProducts)) {
    $products[] = $row;
}

mysqli_stmt_close($stmt);



// RETURN RESPONSE

echo json_encode([
    "success" => true,
    "category" => $category,
    "pagination" => [
        "page" => $page,
        "limit" => $limit,
        "total_products" => (int)$totalProducts,
        "total_pages" => ceil($totalProducts / $limit)
    ],
    "products" => $products
]);

mysqli_close($conn);

?>