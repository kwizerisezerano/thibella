<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Content-Type: application/json");
header("Access-Control-Allow-Methods: GET, OPTIONS");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS'){
    http_response_code(200);
    exit;
}

include("../connection.php");

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try {

    // PAGINATION PARAMETERS

    $page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
    $limit = isset($_GET['limit']) ? (int) $_GET['limit'] : 16;

    if ($page < 1) $page = 1;
    if ($limit < 1) $limit = 16;

    $offset = ($page - 1) * $limit;
  
    // GET TOTAL PRODUCTS

    $countSql = "SELECT COUNT(*) as total FROM products";
    $countResult = mysqli_query($conn, $countSql);
    $countRow = mysqli_fetch_assoc($countResult);
    $totalProducts = $countRow['total'];

    // GET PRODUCTS WITH PAGINATION

    $sql = "SELECT * FROM products LIMIT $limit OFFSET $offset";

    $result = mysqli_query($conn, $sql);

    $products = [];

    while ($row = mysqli_fetch_assoc($result)) {

        // decode color safely
        if (isset($row['color']) && is_string($row['color'])) {
            $decoded = json_decode($row['color'], true);
            $row['color'] = is_string($decoded) ? json_decode($decoded, true) : $decoded;
        }

        // decode size safely
        if (isset($row['size']) && is_string($row['size'])) {
            $decoded = json_decode($row['size'], true);
            $row['size'] = is_string($decoded) ? json_decode($decoded, true) : $decoded;
        }

        // decode possible images safely
        if (isset($row['possibleImagesUrls']) && is_string($row['possibleImagesUrls'])) {
            $row['possibleImagesUrls'] = json_decode($row['possibleImagesUrls'], true);
        }

        $products[] = $row;
    }

    // RETURN RESPONSE

    echo json_encode([
        "success" => true,
        "pagination" => [
            "page" => $page,
            "limit" => $limit,
            "total_products" => (int)$totalProducts,
            "total_pages" => ceil($totalProducts / $limit)
        ],
        "data" => $products
    ]);

} catch (mysqli_sql_exception $e) {

    http_response_code(500);

    echo json_encode([
        "success" => false,
        "error" => "Failed to retrieve products",
        // remove in production
        "message" => $e->getMessage()
    ]);

} finally {

    if(isset($conn)) {
        mysqli_close($conn);
    }

}