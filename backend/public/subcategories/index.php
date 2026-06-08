<?php

require_once __DIR__ . '/../bootstrap.php';
require_once __DIR__ . '/../../controllers/SubcategoryController.php';

$ctrl   = new SubcategoryController();
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
// GET  (no params)              → all subcategories
// GET  ?id=1                    → single by id
// GET  ?slug=sneakers           → single by slug
// GET  ?category_id=2           → all subcategories for a category
// GET  ?category_id=2&with_category=1 → include parent category object
// GET  ?slug=cars&with_category=1     → subcategory by slug + parent category
// POST body: { name, slug, category_id, image? }
// PUT  ?id=1  body: { name?, slug?, category_id?, image? }
// DELETE ?id=1
