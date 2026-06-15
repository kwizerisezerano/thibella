<?php

require_once __DIR__ . '/router.php';
require_once __DIR__ . '/../controllers/OrderController.php';

$ctrl      = new OrderController();
$method    = $_SERVER['REQUEST_METHOD'];
$subAction = $GLOBALS['subAction'] ?? '';

// GET /api/orders/user?user_id=5  (auth — user sees own orders, admin sees any)
if ($method === 'GET' && $subAction === 'user') {
    require_once __DIR__ . '/../middleware/auth.php';
    $ctrl->userOrders($authUser);
    exit;
}

switch ($method) {
    case 'GET':
        require_once __DIR__ . '/../middleware/admin.php';
        $ctrl->index();
        break;
    case 'POST':
        // Order creation is now admin-only
        require_once __DIR__ . '/../middleware/admin.php';
        $ctrl->store($authUser);
        break;
    case 'PUT':
        require_once __DIR__ . '/../middleware/admin.php';
        $ctrl->updateStatus();
        break;
    default:
        Response::error('Method not allowed', 405);
}
