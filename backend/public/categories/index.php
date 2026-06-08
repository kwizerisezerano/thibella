<?php

require_once __DIR__ . '/../bootstrap.php';
require_once __DIR__ . '/../../controllers/CategoryController.php';

$ctrl   = new CategoryController();
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
// GET  ?id=1                    → single category by id
// GET  ?slug=cars               → single category by slug
// GET  ?with_subcategories=1    → embed subcategories in each category
// GET  ?with_subcategories=1&slug=cars → category + its subcategories
// POST body: { title, slug, description?, image? }
// PUT  ?id=1  body: { title?, description?, slug?, image? }
// DELETE ?id=1
