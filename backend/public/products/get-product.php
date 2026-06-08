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

    // Check if id exists

    if(!isset($_GET['id'])){
        http_response_code(400);
        echo json_encode([
            "success" => false,
            "error" => "Product ID is required"
        ]);
        exit;
    }
    // Fetch products from database

    $productId = $_GET['id'];

    $sql = "SELECT * FROM products WHERE id = ?";

    $stmt = mysqli_prepare($conn, $sql);

    mysqli_stmt_bind_param($stmt, "i", $productId);

    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);

    $product = mysqli_fetch_assoc($result);

    if (!$product) {
        http_response_code(404);
        echo json_encode([
            "success" => false,
            "message" => "Product not found"
        ]);
        exit;
    }


$product['size'] = json_decode($product['size'], true);
$product['color'] = json_decode($product['color'], true);
$product['possibleImagesUrls'] = json_decode($product['possibleImagesUrls'], true);

// echo json_encode($product);


    echo json_encode([
        "success" => true,
        "data" => $product
    ]);

} catch(mysqli_sql_exception $e) {

  http_response_code(500);
  echo json_encode([
     "success" => false,
    "error" => "Failed to retrieve product",
    // i have to never forget hidding this on production
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


