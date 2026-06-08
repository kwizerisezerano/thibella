<?php

require_once __DIR__ . '/../bootstrap.php';
require_once __DIR__ . '/../../controllers/ProductController.php';

$ctrl   = new ProductController();
$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'GET':
        $ctrl->index();
        break;
    case 'POST':
        require_once __DIR__ . '/../../middleware/admin.php';
        $ctrl->store();
        break;
    case 'PUT':
        require_once __DIR__ . '/../../middleware/admin.php';
        $ctrl->update();
        break;
    case 'DELETE':
        require_once __DIR__ . '/../../middleware/admin.php';
        $ctrl->destroy();
        break;
    default:
        Response::error('Method not allowed', 405);
}

// ── Query params supported ────────────────────────────────────────────────────
// GET  (no params)              → all products (paginated)
// GET  ?id=1                    → single product by id
// GET  ?category_id=1           → products by category
// GET  ?subcategory_id=3        → products by subcategory  (replaces by-subcategory + get_by_subcategory)
// GET  ?sale=1                  → on-sale products only
// GET  ?search=jordan           → search by product name
// GET  ?sort=newest|oldest|price_asc|price_desc
// GET  ?page=1&limit=16         → pagination (max limit: 100)
// Combinable: ?category_id=1&sale=1&sort=price_asc&page=2&limit=8
//
// POST multipart/form-data:
//   productName*  category_id*  description  priceCents  subCategory_id
//   type  isOnSale  imageUrl  size(JSON)  color(JSON)  possibleImagesUrls(JSON)
//
// PUT  ?id=1  JSON body: any product fields
// DELETE ?id=1
