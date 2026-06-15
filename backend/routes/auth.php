<?php

require_once __DIR__ . '/../controllers/AuthController.php';

$ctrl   = new AuthController();
$method = $_SERVER['REQUEST_METHOD'];
$action = $GLOBALS['subAction'] ?? ''; // 'login' or 'register'

if ($method !== 'POST') {
    Response::error('Method not allowed', 405);
}

match ($action) {
    'login'    => $ctrl->login(),
    'register' => function () use ($ctrl) {
        // Registration is now admin-only
        require_once __DIR__ . '/../middleware/admin.php';
        $ctrl->register();
    },
    default    => Response::error("Auth action '{$action}' not found", 404),
};
