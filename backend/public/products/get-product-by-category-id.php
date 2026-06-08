<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Content-Type: application/json");
header("Access-Control-Allow-Methods: GET, OPTIONS");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

require_once "../connection.php";

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try {

    // Get category ID
    $categoryId = intval($_GET['category_id'] ?? 0);

    if ($categoryId <= 0) {
        http_response_code(400);

        echo json_encode([
            "success" => false,
            "message" => "Category ID is required"
        ]);
        exit;
    }

    $sql = "
        SELECT *
        FROM products
        WHERE category_id = ?
        ORDER BY id DESC
    ";

    $stmt = mysqli_prepare($conn, $sql);

    mysqli_stmt_bind_param($stmt, "i", $categoryId);

    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);

    $products = [];

    while ($product = mysqli_fetch_assoc($result)) {

        $product['size'] = json_decode($product['size'], true);
        $product['color'] = json_decode($product['color'], true);
        $product['possibleImagesUrls'] = json_decode($product['possibleImagesUrls'], true);

        $products[] = $product;
    }

    echo json_encode([
        "success" => true,
        "data" => $products,
        "message" => "Products retrieved successfully"
    ]);

} catch (mysqli_sql_exception $e) {

    http_response_code(500);

    echo json_encode([
        "success" => false,
        "error" => "Failed to retrieve products",
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