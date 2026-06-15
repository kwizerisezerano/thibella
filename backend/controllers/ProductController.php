<?php

require_once __DIR__ . '/../core/DB.php';
require_once __DIR__ . '/../core/Response.php';
require_once __DIR__ . '/../core/helpers.php';

class ProductController
{
    // Decode JSON fields stored in DB as strings - if not valid JSON, return as string
    private function decode(array $row): array
    {
        foreach (['possibleImagesUrls'] as $f) {
            if (!empty($row[$f]) && is_string($row[$f])) {
                $decoded = json_decode($row[$f], true);
                $row[$f] = is_array($decoded) ? $decoded : [];
            }
        }
        // For size and color, if stored as JSON but we want to treat as string, just return as is
        foreach (['size', 'color'] as $f) {
            if (!empty($row[$f]) && is_string($row[$f])) {
                $decoded = json_decode($row[$f], true);
                $row[$f] = is_array($decoded) ? (implode(', ', $decoded)) : $row[$f];
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
            'price_asc'  => 'price ASC',
            'price_desc' => 'price DESC',
            'oldest'     => 'id ASC',
            'newest'     => 'id DESC',
        ];
        $orderSQL = 'ORDER BY ' . ($sortMap[qStr('sort', 'newest')] ?? 'id DESC');

        // ── Pagination ───────────────────────────────────────────────────────
        [$page, $limit, $offset] = getPagination(10);

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
    // multipart/form-data: productName*, category_id*, description, price,
    //   subCategory_id, isOnSale, imageUrl, size, color,
    //   possibleImagesUrls(JSON), stock, brand, currency (default RWF)
    public function store(): void
    {
        $d        = jsonBody();
        $name     = trim($d['productName'] ?? '');
        $catId    = !empty($d['category_id']) ? (int) $d['category_id'] : null;
        $desc     = trim($d['description']      ?? '');
        $price    = (float) ($d['price']     ?? 0);
        $subCatId = !empty($d['subCategory_id']) ? (int) $d['subCategory_id'] : null;
        $isOnSale = (int) ($d['isOnSale']       ?? 0);
        $imageUrl = trim($d['imageUrl']         ?? '');
        $brand    = trim($d['brand']            ?? '');
        $stock    = (int) ($d['stock']           ?? 0);
        $size     = is_array($d['size'] ?? null) ? json_encode($d['size']) : (trim($d['size'] ?? ''));
        $color    = is_array($d['color'] ?? null) ? json_encode($d['color']) : (trim($d['color'] ?? ''));
        $images   = $this->safeJson(is_array($d['possibleImagesUrls'] ?? null) ? json_encode($d['possibleImagesUrls']) : ($d['possibleImagesUrls'] ?? '[]'));
        $currency = trim($d['currency'] ?? 'RWF');

        if (!$name || !$catId) Response::error('productName and category_id are required', 400);

        if (DB::fetchOne('SELECT id FROM products WHERE productName = ? AND category_id = ?', 'si', [$name, $catId]))
            Response::error('Product with this name already exists in the same category', 409);

        $id = DB::insert(
            'INSERT INTO products
                (productName, description, price, size, color, isOnSale,
                 imageUrl, possibleImagesUrls, brand, stock, category_id, subCategory_id, currency)
             VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)',
            'ssdssisssiiis',
            [$name, $desc, $price, $size, $color, $isOnSale, $imageUrl, $images, $brand, $stock, $catId, $subCatId, $currency]
        );

        Response::success(['id' => $id], 'Product created');
    }

    // ── PUT /api/products?id=1  (admin) ──────────────────────────────────────
    // JSON body: any product fields
    public function update(): void
    {
        $id = qInt('id');
        if (!$id) Response::error('id is required', 400);

        $d       = jsonBody();
        $current = DB::fetchOne('SELECT * FROM products WHERE id = ?', 'i', [$id]);
        if (!$current) Response::error('Product not found', 404);

        foreach (['productName','description','imageUrl','brand','currency'] as $f) {
            if (array_key_exists($f, $d) && (string)$d[$f] === (string)($current[$f] ?? '')) unset($d[$f]);
        }
        foreach (['isOnSale','category_id','subCategory_id','stock'] as $f) {
            if (array_key_exists($f, $d) && (int)$d[$f] === (int)($current[$f] ?? 0)) unset($d[$f]);
        }
        // Handle price as float
        if (array_key_exists('price', $d) && (float)$d['price'] === (float)($current['price'] ?? 0)) unset($d['price']);
        foreach (['size', 'color', 'possibleImagesUrls'] as $f) {
            if (array_key_exists($f, $d)) {
                $incoming = is_array($d[$f]) ? json_encode($d[$f]) : (string)$d[$f];
                if ($incoming === (string)($current[$f] ?? '')) unset($d[$f]);
                else $d[$f] = $incoming;
            }
        }

        [$fields, $types, $values] = buildUpdate($d, [
            'productName'        => 's',
            'description'        => 's',
            'price'              => 'd', // d for double/decimal
            'size'               => 's',
            'color'              => 's',
            'isOnSale'           => 'i',
            'imageUrl'           => 's',
            'possibleImagesUrls' => 's',
            'brand'              => 's',
            'stock'              => 'i',
            'category_id'        => 'i',
            'subCategory_id'     => 'i',
            'currency'           => 's',
        ]);

        if (empty($fields)) Response::success(null, 'Nothing to update, values are the same');

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

        if (!DB::fetchOne('SELECT id FROM products WHERE id = ?', 'i', [$id]))
            Response::error('Product not found', 404);

        DB::execute('DELETE FROM products WHERE id = ?', 'i', [$id]);
        Response::success(null, 'Product deleted');
    }

    // ── Private ───────────────────────────────────────────────────────────────
    private function safeJson(string $value): string
    {
        return json_decode($value) !== null ? $value : '[]';
    }
}
