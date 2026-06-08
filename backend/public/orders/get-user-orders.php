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
    // ✅ Get userId from query string e.g. ?userId=123
    $userId = $_GET['userId'] ?? null;

    if (empty($userId)) {
        http_response_code(400);
        echo json_encode([
            "success" => false,
            "message" => "userId is required"
        ]);
        exit;
    }

    // ✅ Only fetch orders belonging to this user
    $ordersSql = "SELECT * FROM orders WHERE user_id = ? ORDER BY id DESC";

    $ordersStmt = mysqli_prepare($conn, $ordersSql);

    mysqli_stmt_bind_param($ordersStmt, "i", $userId);

    mysqli_stmt_execute($ordersStmt);

    $ordersResult = mysqli_stmt_get_result($ordersStmt);

    $orders = [];

    while ($order = mysqli_fetch_assoc($ordersResult)) {

        // Mask sensitive info
        if (!empty($order['card_number'])) {
            $order['card_number'] = '************' . substr($order['card_number'], -4);
        }

        if (!empty($order['mobile_money_number'])) {
            $order['mobile_money_number'] = '******' . substr($order['mobile_money_number'], -4);
        }

        // Fetch order items for this order
        $itemsSql = "SELECT * FROM order_items WHERE order_id = ?";
        $itemsStmt = mysqli_prepare($conn, $itemsSql);
        mysqli_stmt_bind_param($itemsStmt, "i", $order['id']);
        mysqli_stmt_execute($itemsStmt);
        $itemsResult = mysqli_stmt_get_result($itemsStmt);

        $items = [];
        while ($item = mysqli_fetch_assoc($itemsResult)) {
            $items[] = $item;
        }

        $order['items'] = $items;
        $orders[] = $order;
    }

    echo json_encode([
        "success" => true,
        "data" => $orders,
        "message" => "Orders retrieved successfully"
    ]);

} catch (mysqli_sql_exception $e) {
    http_response_code(500);
    echo json_encode([
        "success" => false,
        "error" => "Failed to retrieve orders",
        "message" => $e->getMessage() // ⚠️ hide this in production
    ]);

} finally {
    if (isset($conn)) mysqli_close($conn);
}