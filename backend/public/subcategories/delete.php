<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
header("Access-Control-Allow-Methods: POST");

require_once "../connection.php";

$id = intval($_POST['id'] ?? 0);

if ($id <= 0) {

    http_response_code(400);

    echo json_encode([
        "success" => false,
        "message" => "id is required"
    ]);

    exit;
}

$sql = "
    DELETE FROM subcategories
    WHERE id = ?
";

$stmt = mysqli_prepare($conn, $sql);

mysqli_stmt_bind_param(
    $stmt,
    "i",
    $id
);

mysqli_stmt_execute($stmt);

echo json_encode([
    "success" => true,
    "message" => "Subcategory deleted successfully"
]);

mysqli_stmt_close($stmt);
mysqli_close($conn);