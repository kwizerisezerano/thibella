<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

require_once "../connection.php";
require_once "../core/helpers.php";

function getLocalizedValue(array $row, string $field, string $locale): string {
    $localizedField = "{$field}_{$locale}";
    return (isset($row[$localizedField]) && $row[$localizedField] !== null) ? $row[$localizedField] : $row[$field];
}

$subcategory_id = intval($_GET['subcategory_id'] ?? 0);

if ($subcategory_id <= 0) {
    http_response_code(400);
    echo json_encode([
        "success" => false,
        "message" => "subcategory_id is required"
    ]);
    exit;
}

$locale = getLocale();

$sql = "
SELECT
    p.*,
    s.name, s.name_rw, s.name_fr, s.name_sw
FROM products p
JOIN subcategories s
ON p.subcategory_id = s.id
WHERE p.subcategory_id = ?
";

$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $subcategory_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

$products = [];
$subcategory_name = '';

while ($row = mysqli_fetch_assoc($result)) {
    $subcategory_name = getLocalizedValue($row, 'name', $locale);
    $products[] = $row;
}

echo json_encode([
    "success" => true,
    "subcategory_name" => $subcategory_name,
    "products" => $products
]);

mysqli_stmt_close($stmt);
mysqli_close($conn);