<?php

require_once __DIR__ . '/../core/DB.php';
require_once __DIR__ . '/../core/Response.php';
require_once __DIR__ . '/../core/helpers.php';

class CategoryController
{
    // ── GET /api/categories ──────────────────────────────────────────────────
    // ?id=1                 → single by id
    // ?slug=cars            → single by slug
    // ?with_subcategories=1 → attach subcategories to each category
    public function index(): void
    {
        $withSubs = qInt('with_subcategories') === 1;

        if ($id = qInt('id')) {
            $row = DB::fetchOne('SELECT * FROM categories WHERE id = ?', 'i', [$id]);
            if (!$row) Response::error('Category not found', 404);
            if ($withSubs) $row['subcategories'] = $this->getSubcategories($row['id']);
            Response::success($row);
        }

        if ($slug = qStr('slug')) {
            $row = DB::fetchOne('SELECT * FROM categories WHERE slug = ?', 's', [$slug]);
            if (!$row) Response::error('Category not found', 404);
            if ($withSubs) $row['subcategories'] = $this->getSubcategories($row['id']);
            Response::success($row);
        }

        $rows = DB::fetchAll('SELECT * FROM categories ORDER BY title ASC');

        if ($withSubs) {
            foreach ($rows as &$row) {
                $row['subcategories'] = $this->getSubcategories($row['id']);
            }
        }

        Response::success($rows);
    }

    // ── POST /api/categories  (admin) ────────────────────────────────────────
    // Body: { title, slug, description?, image? }
    public function store(): void
    {
        $d = jsonBody();

        if (empty($d['title']) || empty($d['slug'])) {
            Response::error('title and slug are required', 400);
        }

        // Duplicate slug check
        if (DB::fetchOne('SELECT id FROM categories WHERE slug = ?', 's', [$d['slug']])) {
            Response::error('Slug already in use', 409);
        }

        $id = DB::insert(
            'INSERT INTO categories (title, description, slug, image) VALUES (?, ?, ?, ?)',
            'ssss',
            [trim($d['title']), trim($d['description'] ?? ''), trim($d['slug']), $d['image'] ?? null]
        );

        Response::success(['id' => $id], 'Category created', 201);
    }

    // ── PUT /api/categories?id=1  (admin) ────────────────────────────────────
    // Body: any of { title, description, slug, image }
    public function update(): void
    {
        $id = qInt('id');
        if (!$id) Response::error('id is required', 400);

        [$fields, $types, $values] = buildUpdate(jsonBody(), [
            'title'       => 's',
            'description' => 's',
            'slug'        => 's',
            'image'       => 's',
        ]);

        if (empty($fields)) Response::error('No fields to update', 400);

        DB::execute(
            'UPDATE categories SET ' . implode(', ', $fields) . ' WHERE id = ?',
            $types . 'i',
            array_merge($values, [$id])
        );

        Response::success(null, 'Category updated');
    }

    // ── DELETE /api/categories?id=1  (admin) ─────────────────────────────────
    public function destroy(): void
    {
        $id = qInt('id');
        if (!$id) Response::error('id is required', 400);

        DB::execute('DELETE FROM categories WHERE id = ?', 'i', [$id]);
        Response::success(null, 'Category deleted');
    }

    // ── Private helper ────────────────────────────────────────────────────────
    private function getSubcategories(int $categoryId): array
    {
        return DB::fetchAll(
            'SELECT * FROM subcategories WHERE category_id = ? ORDER BY name ASC',
            'i', [$categoryId]
        );
    }
}
