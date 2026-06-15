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
require_once "../core/helpers.php";

function applyLocaleToSubcategory(array $row, string $locale): array {
    if ($locale !== 'en') {
        $row['name'] = isset($row["name_{$locale}"]) && $row["name_{$locale}"] !== null ? $row["name_{$locale}"] : $row['name'];
    }
    unset($row['name_rw'], $row['name_fr'], $row['name_sw']);
    return $row;
}

$locale = getLocale();
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try {
    // Check if category_id exists
    if(!isset($_GET['category_id'])){
        http_response_code(400);
        echo json_encode([
            "success" => false,
            "error" => "Category ID is required"
        ]);
        exit;
    }

    $categoryId = $_GET['category_id'];

    $sql = "SELECT * FROM subcategories WHERE category_id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $categoryId);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    $subcategories = [];
    while($row = mysqli_fetch_assoc($result)){
        $subcategories[] = applyLocaleToSubcategory($row, $locale);
    }

    if(empty($subcategories)){
        http_response_code(404);
        echo json_encode([
            "success" => false,
            "message" => "No subcategories found for this category"
        ]);
        exit;
    }

    echo json_encode([
        "success" => true,
        "data" => $subcategories
    ]);

} catch(mysqli_sql_exception $e) {
    http_response_code(500);
    echo json_encode([
        "success" => false,
        "error" => "Failed to retrieve subcategories",
        // Remember to hide this in production
       // "message" => $e->getMessage()
    ]);

} finally {
    if (isset($stmt)) {
        mysqli_stmt_close($stmt);
    }
    if (isset($conn)) {
        mysqli_close($conn);
    }
}