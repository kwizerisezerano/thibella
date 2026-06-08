<?php

require_once __DIR__ . '/../bootstrap.php';
require_once __DIR__ . '/../../controllers/OrderController.php';

$ctrl      = new OrderController();
$method    = $_SERVER['REQUEST_METHOD'];
$subAction = trim($_GET['action'] ?? ''); // ?action=user

// GET ?action=user&user_id=5  → orders for a specific user (auth)
if ($method === 'GET' && $subAction === 'user') {
    require_once __DIR__ . '/../../middleware/auth.php';
    $ctrl->userOrders();
}

switch ($method) {
    case 'GET':
        require_once __DIR__ . '/../../middleware/admin.php';
        $ctrl->index();
        break;
    case 'POST':
        require_once __DIR__ . '/../../middleware/auth.php';
        $ctrl->store();
        break;
    case 'PUT':
        require_once __DIR__ . '/../../middleware/admin.php';
        $ctrl->updateStatus();
        break;
    default:
        Response::error('Method not allowed', 405);
}

// ── Query params supported ────────────────────────────────────────────────────
// GET  (admin)                         → all orders paginated
// GET  ?page=1&limit=10                → paginated
// GET  ?status=pending                 → filter by status
// GET  ?action=user&user_id=5  (auth)  → orders for a specific user
// POST body (auth): { userId, fullName, phoneNumber, email, country, province,
//   district, sector, nearbyLandmark, paymentMethod, mobileMoneyNumber,
//   orderItems: [{ productId, productName, priceCents, quantity,
//                  selectedColor, selectedSize, imageUrl }] }
// PUT  ?id=1  body: { status }  (admin) → update order status
