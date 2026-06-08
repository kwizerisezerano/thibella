<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Content-Type: application/json");
header("Access-Control-Allow-Methods: GET, OPTIONS");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

include("../connection.php");

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try {

    // ─── Pagination parameters ────────────────────────────────────────────────
    $page  = isset($_GET['page'])  ? (int) $_GET['page']  : 1;
    $limit = isset($_GET['limit']) ? (int) $_GET['limit'] : 10;

    if ($page  < 1) $page  = 1;
    if ($limit < 1) $limit = 10;

    $offset = ($page - 1) * $limit;

    // ─── Total order count ────────────────────────────────────────────────────
    $countResult  = mysqli_query($conn, "SELECT COUNT(*) AS total FROM orders");
    $countRow     = mysqli_fetch_assoc($countResult);
    $totalOrders  = (int) $countRow['total'];
    $totalPages   = (int) ceil($totalOrders / $limit);

    // ─── Fetch paginated orders ───────────────────────────────────────────────
    $ordersSql    = "SELECT * FROM orders ORDER BY id DESC LIMIT ? OFFSET ?";
    $ordersStmt   = mysqli_prepare($conn, $ordersSql);
    mysqli_stmt_bind_param($ordersStmt, "ii", $limit, $offset);
    mysqli_stmt_execute($ordersStmt);
    $ordersResult = mysqli_stmt_get_result($ordersStmt);

    $orders = [];
    $number = '';

    while ($order = mysqli_fetch_assoc($ordersResult)) {

        // ── Mask sensitive fields ─────────────────────────────────────────────
        if (!empty($order['card_number'])) {
            $number = $order['card_number'];
            $order['card_number'] = '************' . substr($number, -4);
        }

        if (!empty($order['mobile_money_number'])) {
            $number = $order['mobile_money_number'];
            $order['mobile_money_number'] = '******' . substr($number, -4);
        }

        // ── Fetch order items for this order ──────────────────────────────────
        $orderId   = $order['id'];
        $itemsSql  = "SELECT * FROM order_items WHERE order_id = ?";
        $itemsStmt = mysqli_prepare($conn, $itemsSql);
        mysqli_stmt_bind_param($itemsStmt, "i", $orderId);
        mysqli_stmt_execute($itemsStmt);
        $itemsResult = mysqli_stmt_get_result($itemsStmt);

        $items = [];
        while ($item = mysqli_fetch_assoc($itemsResult)) {
            $items[] = $item;
        }

        mysqli_stmt_close($itemsStmt);

        $order['items'] = $items;
        $orders[]       = $order;
    }

    mysqli_stmt_close($ordersStmt);

    // ─── Response ─────────────────────────────────────────────────────────────
    echo json_encode([
        "success"    => true,
        "pagination" => [
            "page"         => $page,
            "limit"        => $limit,
            "total_orders" => $totalOrders,
            "total_pages"  => $totalPages
        ],
        "data"    => $orders,
        "message" => "Orders retrieved successfully"
    ]);

} catch (mysqli_sql_exception $e) {

    http_response_code(500);
    echo json_encode([
        "success" => false,
        "error"   => "Failed to retrieve orders",
        // TODO: remove message in production
        "message" => $e->getMessage()
    ]);

} finally {

    if (isset($conn)) {
        mysqli_close($conn);
    }
}