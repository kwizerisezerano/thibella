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

    // Get category slug
    $slug = trim($_GET['slug'] ?? '');

    if (empty($slug)) {
        http_response_code(400);

        echo json_encode([
            "success" => false,
            "message" => "Category slug is required"
        ]);
        exit;
    }

    $sql = "
        SELECT
            s.id,
            s.name,
            s.slug,
            s.image,
            s.category_id,
            c.title AS category_name,
            c.slug AS category_slug
        FROM subcategories s
        INNER JOIN categories c
            ON s.category_id = c.id
        WHERE c.slug = ?
        ORDER BY s.id DESC
    ";

    $stmt = mysqli_prepare($conn, $sql);

    mysqli_stmt_bind_param($stmt, "s", $slug);

    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);

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
        "message" => $e->getMessage()
    ]);

} finally {

    if (isset($conn)) {
        mysqli_close($conn);
    }

}