<?php

require_once __DIR__ . '/../core/DB.php';
require_once __DIR__ . '/../core/Response.php';
require_once __DIR__ . '/../core/helpers.php';

class CategoryController
{
    // ── GET /api/categories ──────────────────────────────────────────────────
    public function index(): void
    {
        $locale   = getLocale();
        $withSubs = qInt('with_subcategories') === 1;

        if ($id = qInt('id')) {
            $row = DB::fetchOne('SELECT * FROM categories WHERE id = ?', 'i', [$id]);
            if (!$row) Response::error('Category not found', 404);
            $row = $this->applyLocale($row, $locale);
            if ($withSubs) $row['subcategories'] = $this->getSubcategories($row['id'], $locale);
            Response::success($row);
        }

        if ($slug = qStr('slug')) {
            $row = DB::fetchOne('SELECT * FROM categories WHERE slug = ?', 's', [$slug]);
            if (!$row) Response::error('Category not found', 404);
            $row = $this->applyLocale($row, $locale);
            if ($withSubs) $row['subcategories'] = $this->getSubcategories($row['id'], $locale);
            Response::success($row);
        }

        [$page, $limit, $offset] = getPagination(10);
        $total = DB::count('categories');
        $rows  = DB::fetchAll('SELECT * FROM categories ORDER BY title ASC LIMIT ? OFFSET ?', 'ii', [$limit, $offset]);

        $rows = array_map(fn($r) => $this->applyLocale($r, $locale), $rows);

        if ($withSubs) {
            foreach ($rows as &$row) {
                $row['subcategories'] = $this->getSubcategories($row['id'], $locale);
            }
        }

        Response::paginated($rows, $total, $page, $limit, 'categories');
    }

    // ── POST /api/categories  (admin) ────────────────────────────────────────
    // Body: { title, slug, description?, image? }
    public function store(): void
    {
        $d = jsonBody();

        if (empty($d['title']) || empty($d['slug'])) {
            Response::error('title and slug are required', 400);
        }

        if (DB::fetchOne('SELECT id FROM categories WHERE slug = ?', 's', [$d['slug']])) {
            Response::error('Slug already in use', 409);
        }

        if (DB::fetchOne('SELECT id FROM categories WHERE title = ?', 's', [$d['title']])) {
            Response::error('Category title already exists', 409);
        }

        $id = DB::insert(
            'INSERT INTO categories (title, description, slug, image) VALUES (?, ?, ?, ?)',
            'ssss',
            [trim($d['title']), trim($d['description'] ?? ''), trim($d['slug']), $d['image'] ?? null]
        );

        Response::success(['id' => $id], 'Category created');
    }

    // ── PUT /api/categories?id=1  (admin) ────────────────────────────────────
    // Body: any of { title, description, slug, image }
    public function update(): void
    {
        $id = qInt('id');
        if (!$id) Response::error('id is required', 400);

        $d = jsonBody();

        $current = DB::fetchOne('SELECT * FROM categories WHERE id = ?', 'i', [$id]);
        if (!$current) Response::error('Category not found', 404);

        // Remove fields that haven't changed
        foreach (['title', 'description', 'slug', 'image'] as $f) {
            if (isset($d[$f]) && (string)$d[$f] === (string)$current[$f]) unset($d[$f]);
        }

        [$fields, $types, $values] = buildUpdate($d, [
            'title'       => 's',
            'description' => 's',
            'slug'        => 's',
            'image'       => 's',
        ]);

        if (empty($fields)) Response::success(null, 'Nothing to update, values are the same');

        if (isset($d['slug'])) {
            if (DB::fetchOne('SELECT id FROM categories WHERE slug = ? AND id != ?', 'si', [$d['slug'], $id]))
                Response::error('Slug already in use', 409);
        }

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

        if (!DB::fetchOne('SELECT id FROM categories WHERE id = ?', 'i', [$id]))
            Response::error('Category not found', 404);

        DB::execute('DELETE FROM categories WHERE id = ?', 'i', [$id]);
        Response::success(null, 'Category deleted');
    }

    // ── Private helpers ───────────────────────────────────────────────────────
    private function applyLocale(array $row, string $locale): array
    {
        if ($locale !== 'en') {
            $row['title']       = $row["title_{$locale}"]       ?: $row['title'];
            $row['description'] = $row["description_{$locale}"] ?: $row['description'];
        }
        unset($row['title_rw'], $row['title_fr'], $row['description_rw'], $row['description_fr']);
        return $row;
    }

    private function getSubcategories(int $categoryId, string $locale = 'en'): array
    {
        $rows = DB::fetchAll(
            'SELECT * FROM subcategories WHERE category_id = ? ORDER BY name ASC',
            'i', [$categoryId]
        );
        return array_map(function ($r) use ($locale) {
            if ($locale !== 'en') {
                $r['name'] = $r["name_{$locale}"] ?: $r['name'];
            }
            unset($r['name_rw'], $r['name_fr']);
            return $r;
        }, $rows);
    }
}
