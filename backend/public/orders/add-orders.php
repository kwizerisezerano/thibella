<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Content-Type: application/json");
header("Access-Control-Allow-Methods: POST, OPTIONS");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS'){
    http_response_code(200);
    exit;
}

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

require_once "../connection.php";

try {
    $rawData = file_get_contents("php://input");

    $data = json_decode($rawData, true);

    if (!$data) {
        throw new Exception("Invalid JSON data");
    }

    // ✅ Get userId from payload — links this order to the logged-in user
    $userId = $data['userId'] ?? null;

    if (empty($userId)) {
        throw new Exception("User ID is required to place an order.");
    }

    // Shipping info
    $fullName        = $data['fullName'] ?? '';
    $phoneNumber     = $data['phoneNumber'] ?? '';
    $email           = $data['email'] ?? '';
    $country         = $data['country'] ?? '';
    $province        = $data['province'] ?? '';
    $district        = $data['district'] ?? '';
    $sector          = $data['sector'] ?? '';
    $nearbyLandmark  = $data['nearbyLandmark'] ?? '';

    // Payment info
    $paymentMethod      = $data['paymentMethod'] ?? '';
    $mobileMoneyNumber  = $data['mobileMoneyNumber'] ?? '';
    $nameOnCard         = $data['nameOnCard'] ?? '';
    $cardNumber         = $data['cardNumber'] ?? '';

    if (empty($data['orderItems'])) {
        throw new Exception("Order items are empty");
    }

    $orderItems = $data['orderItems'] ?? [];

    // Calculate order total
    $orderTotalAmount = 0;
    foreach ($orderItems as $item) {
        $orderTotalAmount += $item['priceCents'] * $item['quantity'];
    }

    $status = "pending";

    // ✅ Added user_id column to INSERT
    $sql = "INSERT INTO
                orders 
                (user_id, full_name, phone_number, email, country, province, district, sector, nearby_landmark, payment_method, mobile_money_number, orderTotalAmount, status)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = mysqli_prepare($conn, $sql);

    // ✅ Added $userId and "i" (integer) at the start of bind_param
    mysqli_stmt_bind_param(
        $stmt,
        "issssssssssis",
        $userId,
        $fullName,
        $phoneNumber,
        $email,
        $country,
        $province,
        $district,
        $sector,
        $nearbyLandmark,
        $paymentMethod,
        $mobileMoneyNumber,
        $orderTotalAmount,
        $status
    );

    mysqli_stmt_execute($stmt);

    // Get the inserted order ID
    $orderId = mysqli_insert_id($conn);

    // Insert order items
    $orderItemSql = "INSERT INTO order_items (order_id, product_id, product_name, price_cents, quantity, selected_color, selected_size, image_url, productTotalAmount) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $orderItemStmt = mysqli_prepare($conn, $orderItemSql);

    foreach ($orderItems as $item) {
        $productTotalAmount = $item['priceCents'] * $item['quantity'];

        mysqli_stmt_bind_param(
            $orderItemStmt,
            "iisissisi",
            $orderId,
            $item['productId'],
            $item['productName'],
            $item['priceCents'],
            $item['quantity'],
            $item['selectedColor'],
            $item['selectedSize'],
            $item['imageUrl'],
            $productTotalAmount
        );
        mysqli_stmt_execute($orderItemStmt);
    }

    echo json_encode([
        "success" => true,
        "message" => "Order received successfully",
        "orderId" => $orderId
    ]);

} catch (Exception $e) {
    echo json_encode([
        "success" => false,
        "message" => $e->getMessage()
    ]);
} finally {
    if (isset($stmt)) mysqli_stmt_close($stmt);
    if (isset($orderItemStmt)) mysqli_stmt_close($orderItemStmt);
    if (isset($conn)) mysqli_close($conn);
}