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
require_once "../core/helpers.php";

function applyLocaleToCategory(array $row, string $locale): array {
    if ($locale !== 'en') {
        $row['title'] = isset($row["title_{$locale}"]) && $row["title_{$locale}"] !== null ? $row["title_{$locale}"] : $row['title'];
        $row['description'] = isset($row["description_{$locale}"]) && $row["description_{$locale}"] !== null ? $row["description_{$locale}"] : $row['description'];
    }
    unset($row['title_rw'], $row['title_fr'], $row['title_sw'], $row['description_rw'], $row['description_fr'], $row['description_sw']);
    return $row;
}

$locale = getLocale();

// Check if id is provided (for single category)
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "SELECT * FROM categories WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);
    $category = mysqli_fetch_assoc($result);

    if ($category) {
        $category = applyLocaleToCategory($category, $locale);
        echo json_encode(["success" => true, "data" => $category]);
    } else {
        http_response_code(404);
        echo json_encode(["success" => false, "message" => "Category not found"]);
    }

    mysqli_stmt_close($stmt);
} else {
    // Get all categories
    $sql = "SELECT * FROM categories ORDER BY id DESC";
    $result = mysqli_query($conn, $sql);

    $categories = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $categories[] = applyLocaleToCategory($row, $locale);
    }

    echo json_encode(["success" => true, "data" => $categories]);
}

mysqli_close($conn);