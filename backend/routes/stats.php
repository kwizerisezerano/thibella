<?php

require_once __DIR__ . '/../core/DB.php';
require_once __DIR__ . '/../core/Response.php';
require_once __DIR__ . '/../core/helpers.php';
require_once __DIR__ . '/../middleware/admin.php';

$locale = getLocale();

$totalProducts   = DB::count('products');
$totalCategories = DB::count('categories');
$totalOrders     = DB::count('orders');
$totalUsers      = DB::count('users');

// Orders by status
$statusRows = DB::fetchAll('SELECT status, COUNT(*) as count FROM orders GROUP BY status', '', []);
$ordersByStatus = [];
foreach ($statusRows as $r) $ordersByStatus[$r['status']] = (int)$r['count'];

// Products per category
$titleExpr = 'c.title';
if ($locale === 'rw') $titleExpr = 'COALESCE(NULLIF(c.title_rw, \'\'), c.title)';
if ($locale === 'fr') $titleExpr = 'COALESCE(NULLIF(c.title_fr, \'\'), c.title)';

$catRows = DB::fetchAll(
    "SELECT $titleExpr as title, COUNT(p.id) as count
     FROM categories c
     LEFT JOIN products p ON p.category_id = c.id
     GROUP BY c.id, title
     ORDER BY count DESC
     LIMIT 8",
    '', []
);

// Orders last 7 days
$dayRows = DB::fetchAll(
    "SELECT DATE(created_at) as day, COUNT(*) as count FROM orders WHERE created_at >= DATE_SUB(CURDATE(), INTERVAL 6 DAY) GROUP BY DATE(created_at) ORDER BY day ASC",
    '', []
);

Response::success([
    'totals' => [
        'products'   => $totalProducts,
        'categories' => $totalCategories,
        'orders'     => $totalOrders,
        'users'      => $totalUsers,
    ],
    'ordersByStatus'       => $ordersByStatus,
    'productsByCategory'   => $catRows,
    'ordersLast7Days'      => $dayRows,
]);
