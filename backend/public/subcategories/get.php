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

    $sql = "
        SELECT
            id,
            name,
            slug,
            image,
            category_id
        FROM subcategories
        ORDER BY id DESC
    ";

    $result = mysqli_query($conn, $sql);

    $subcategories = [];

    while ($row = mysqli_fetch_assoc($result)) {
        $subcategories[] = $row;
    }

    echo json_encode([
        "success" => true,
        "data" => $subcategories,
        "message" => "Subcategories retrieved successfully"
    ]);

} catch (mysqli_sql_exception $e) {

    http_response_code(500);

    echo json_encode([
        "success" => false,
        "error" => "Failed to retrieve subcategories",
        "message" => $e->getMessage() // Hide in production
    ]);

} finally {

    if (isset($conn)) {
        mysqli_close($conn);
    }

}