<?php

require_once __DIR__ . '/../core/DB.php';
require_once __DIR__ . '/../core/Response.php';
require_once __DIR__ . '/../core/helpers.php';

class SubcategoryController
{
    // ── GET /api/subcategories ───────────────────────────────────────────────
    // ?id=1              → single by id
    // ?slug=sneakers     → single by slug
    // ?category_id=2     → all belonging to a category
    // ?with_category=1   → attach parent category object to each result
    public function index(): void
    {
        $withCat = qInt('with_category') === 1;

        if ($id = qInt('id')) {
            $row = DB::fetchOne('SELECT * FROM subcategories WHERE id = ?', 'i', [$id]);
            if (!$row) Response::error('Subcategory not found', 404);
            if ($withCat) $row['category'] = $this->getCategory($row['category_id']);
            Response::success($row);
        }

        if ($slug = qStr('slug')) {
            $row = DB::fetchOne('SELECT * FROM subcategories WHERE slug = ?', 's', [$slug]);
            if (!$row) Response::error('Subcategory not found', 404);
            if ($withCat) $row['category'] = $this->getCategory($row['category_id']);
            Response::success($row);
        }

        if ($catId = qInt('category_id')) {
            $rows = DB::fetchAll(
                'SELECT * FROM subcategories WHERE category_id = ? ORDER BY name ASC',
                'i', [$catId]
            );
            if ($withCat) {
                $cat = $this->getCategory($catId);
                foreach ($rows as &$row) $row['category'] = $cat;
            }
            Response::success($rows);
        }

        $rows = DB::fetchAll('SELECT * FROM subcategories ORDER BY name ASC');
        Response::success($rows);
    }

    // ── POST /api/subcategories  (admin) ─────────────────────────────────────
    // Body: { name, slug, category_id, image? }
    public function store(): void
    {
        $d = jsonBody();

        if (empty($d['name']) || empty($d['slug']) || empty($d['category_id'])) {
            Response::error('name, slug and category_id are required', 400);
        }

        $name       = trim($d['name']);
        $slug       = trim($d['slug']);
        $categoryId = (int) $d['category_id'];
        $image      = $d['image'] ?? null;

        if (DB::fetchOne('SELECT id FROM subcategories WHERE slug = ?', 's', [$slug])) {
            Response::error('Slug already in use', 409);
        }

        $id = DB::insert(
            'INSERT INTO subcategories (name, category_id, slug, image) VALUES (?, ?, ?, ?)',
            'siss',
            [$name, $categoryId, $slug, $image]
        );

        Response::success(['id' => $id], 'Subcategory created', 201);
    }

    // ── PUT /api/subcategories?id=1  (admin) ─────────────────────────────────
    // Body: any of { name, slug, category_id, image }
    public function update(): void
    {
        $id = qInt('id');
        if (!$id) Response::error('id is required', 400);

        [$fields, $types, $values] = buildUpdate(jsonBody(), [
            'name'        => 's',
            'slug'        => 's',
            'category_id' => 'i',
            'image'       => 's',
        ]);

        if (empty($fields)) Response::error('No fields to update', 400);

        DB::execute(
            'UPDATE subcategories SET ' . implode(', ', $fields) . ' WHERE id = ?',
            $types . 'i',
            array_merge($values, [$id])
        );

        Response::success(null, 'Subcategory updated');
    }

    // ── DELETE /api/subcategories?id=1  (admin) ──────────────────────────────
    public function destroy(): void
    {
        $id = qInt('id');
        if (!$id) Response::error('id is required', 400);

        DB::execute('DELETE FROM subcategories WHERE id = ?', 'i', [$id]);
        Response::success(null, 'Subcategory deleted');
    }

    // ── Private helper ────────────────────────────────────────────────────────
    private function getCategory(int $id): ?array
    {
        return DB::fetchOne('SELECT * FROM categories WHERE id = ?', 'i', [$id]);
    }
}
