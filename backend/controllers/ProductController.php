<?php

require_once __DIR__ . '/../core/DB.php';
require_once __DIR__ . '/../core/Response.php';
require_once __DIR__ . '/../core/helpers.php';

class ProductController
{
    // Decode JSON fields stored in DB as strings
    private function decode(array $row): array
    {
        foreach (['size', 'color', 'possibleImagesUrls'] as $f) {
            if (!empty($row[$f]) && is_string($row[$f])) {
                $decoded = json_decode($row[$f], true);
                $row[$f] = is_array($decoded) ? $decoded : [];
            }
        }
        return $row;
    }

    // ── GET /api/products ────────────────────────────────────────────────────
    // ?id=1               → single product
    // ?category_id=1      → filter by category
    // ?subcategory_id=3   → filter by subcategory
    // ?sale=1             → on-sale only
    // ?search=jordan      → name search
    // ?sort=price_asc | price_desc | newest (default) | oldest
    // ?page=1 &limit=16   → pagination
    public function index(): void
    {
        if ($id = qInt('id')) {
            $row = DB::fetchOne('SELECT * FROM products WHERE id = ?', 'i', [$id]);
            if (!$row) Response::error('Product not found', 404);
            Response::success($this->decode($row));
        }

        // ── Filters ──────────────────────────────────────────────────────────
        $where  = [];
        $types  = '';
        $values = [];

        if ($catId = qInt('category_id')) {
            $where[] = 'category_id = ?'; $types .= 'i'; $values[] = $catId;
        }
        if ($subId = qInt('subcategory_id')) {
            $where[] = 'subCategory_id = ?'; $types .= 'i'; $values[] = $subId;
        }
        if (qInt('sale') === 1) {
            $where[] = 'isOnSale = 1';
        }
        if ($search = qStr('search')) {
            $where[] = 'productName LIKE ?'; $types .= 's'; $values[] = "%$search%";
        }

        $whereSQL = $where ? 'WHERE ' . implode(' AND ', $where) : '';

        // ── Sort ─────────────────────────────────────────────────────────────
        $sortMap = [
            'price_asc'  => 'priceCents ASC',
            'price_desc' => 'priceCents DESC',
            'oldest'     => 'id ASC',
            'newest'     => 'id DESC',
        ];
        $orderSQL = 'ORDER BY ' . ($sortMap[qStr('sort', 'newest')] ?? 'id DESC');

        // ── Pagination ───────────────────────────────────────────────────────
        [$page, $limit, $offset] = getPagination(16);

        $total = DB::count('products', ltrim($whereSQL, 'WHERE '), $types, $values);

        $rows = DB::fetchAll(
            "SELECT * FROM products $whereSQL $orderSQL LIMIT ? OFFSET ?",
            $types . 'ii',
            array_merge($values, [$limit, $offset])
        );

        Response::paginated(
            array_map([$this, 'decode'], $rows),
            $total, $page, $limit, 'products'
        );
    }

    // ── POST /api/products  (admin) ──────────────────────────────────────────
    // multipart/form-data: productName*, category_id*, description, priceCents,
    //   subCategory_id, type, isOnSale, imageUrl, size(JSON), color(JSON),
    //   possibleImagesUrls(JSON)
    public function store(): void
    {
        $name       = trim($_POST['productName']      ?? '');
        $catId      = (int) ($_POST['category_id']    ?? 0);
        $desc       = trim($_POST['description']      ?? '');
        $price      = (int) ($_POST['priceCents']     ?? 0);
        $subCatId   = (int) ($_POST['subCategory_id'] ?? 0);
        $type       = trim($_POST['type']             ?? '');
        $isOnSale   = (int) ($_POST['isOnSale']       ?? 0);
        $imageUrl   = trim($_POST['imageUrl']         ?? '');
        $brand      = trim($_POST['brand']            ?? '');
        $size       = $this->safeJson($_POST['size']               ?? '[]');
        $color      = $this->safeJson($_POST['color']              ?? '[]');
        $images     = $this->safeJson($_POST['possibleImagesUrls'] ?? '[]');

        if (!$name || !$catId) Response::error('productName and category_id are required', 400);

        $id = DB::insert(
            'INSERT INTO products
                (productName, description, priceCents, size, color, type, isOnSale,
                 imageUrl, possibleImagesUrls, brand, category_id, subCategory_id)
             VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)',
            'ssississssii',
            [$name, $desc, $price, $size, $color, $type, $isOnSale, $imageUrl, $images, $brand, $catId, $subCatId]
        );

        Response::success(['id' => $id], 'Product created');
    }

    // ── PUT /api/products?id=1  (admin) ──────────────────────────────────────
    // JSON body: any product fields
    public function update(): void
    {
        $id = qInt('id');
        if (!$id) Response::error('id is required', 400);

        [$fields, $types, $values] = buildUpdate(jsonBody(), [
            'productName'        => 's',
            'description'        => 's',
            'priceCents'         => 'i',
            'size'               => 's',
            'color'              => 's',
            'type'               => 's',
            'isOnSale'           => 'i',
            'imageUrl'           => 's',
            'possibleImagesUrls' => 's',
            'brand'              => 's',
            'category_id'        => 'i',
            'subCategory_id'     => 'i',
        ]);

        if (empty($fields)) Response::error('No fields to update', 400);

        DB::execute(
            'UPDATE products SET ' . implode(', ', $fields) . ' WHERE id = ?',
            $types . 'i',
            array_merge($values, [$id])
        );

        Response::success(null, 'Product updated');
    }

    // ── DELETE /api/products?id=1  (admin) ───────────────────────────────────
    public function destroy(): void
    {
        $id = qInt('id');
        if (!$id) Response::error('id is required', 400);

        DB::execute('DELETE FROM products WHERE id = ?', 'i', [$id]);
        Response::success(null, 'Product deleted');
    }

    // ── Private ───────────────────────────────────────────────────────────────
    private function safeJson(string $value): string
    {
        return json_decode($value) !== null ? $value : '[]';
    }
}
