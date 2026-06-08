<?php

/**
 * Dispatch HTTP method → controller action.
 * Admin-protected methods require middleware/admin.php.
 */
function dispatch(object $ctrl, array $protected = ['POST', 'PUT', 'DELETE']): void
{
    $method = $_SERVER['REQUEST_METHOD'];

    $map = [
        'GET'    => 'index',
        'POST'   => 'store',
        'PUT'    => 'update',
        'DELETE' => 'destroy',
    ];

    if (!isset($map[$method])) {
        Response::error('Method not allowed', 405);
    }

    if (in_array($method, $protected, true)) {
        require_once __DIR__ . '/../middleware/admin.php';
    }

    $ctrl->{$map[$method]}();
}
