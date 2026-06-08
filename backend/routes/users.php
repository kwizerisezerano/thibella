<?php

require_once __DIR__ . '/../controllers/UserController.php';

$ctrl      = new UserController();
$method    = $_SERVER['REQUEST_METHOD'];
$subAction = $GLOBALS['subAction'] ?? '';

// GET  /api/users/profile?id=1  (auth)
// PUT  /api/users/profile?id=1  (auth)
if ($subAction === 'profile') {
    require_once __DIR__ . '/../middleware/auth.php';
    match ($method) {
        'GET' => $ctrl->profile($authUser),
        'PUT' => $ctrl->updateProfile($authUser),
        default => Response::error('Method not allowed', 405),
    };
    exit;
}

// Admin-only routes
require_once __DIR__ . '/../middleware/admin.php';

switch ($method) {
    case 'GET':
        $ctrl->index();
        break;
    case 'DELETE':
        $ctrl->destroy();
        break;
    default:
        Response::error('Method not allowed', 405);
}
