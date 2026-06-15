<?php

require_once __DIR__ . '/core/headers.php';
require_once __DIR__ . '/core/Response.php';

setCorsHeaders();

// Normalise URI: strip leading slash, strip subfolder prefix up to /api/
$uri = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
$uri = preg_replace('#^.*?api/#', '', $uri);   // remove anything before api/
$uri = preg_replace('#^api/?#', '', $uri);      // or just api/ with no subfolder

$segments = array_values(array_filter(explode('/', $uri)));
// $segments[0] = resource,  $segments[1] = optional sub-action

$resource  = $segments[0] ?? '';
$subAction = $segments[1] ?? '';

$routes = [
    'auth'          => __DIR__ . '/routes/auth.php',
    'categories'    => __DIR__ . '/routes/categories.php',
    'subcategories' => __DIR__ . '/routes/subcategories.php',
    'products'      => __DIR__ . '/routes/products.php',
    'orders'        => __DIR__ . '/routes/orders.php',
    'users'         => __DIR__ . '/routes/users.php',
    'stats'         => __DIR__ . '/routes/stats.php',
];

if (isset($routes[$resource])) {
    // expose sub-action to route files
    $GLOBALS['subAction'] = $subAction;
    require $routes[$resource];
    exit;
}

Response::error("Endpoint /{$uri} not found", 404);
