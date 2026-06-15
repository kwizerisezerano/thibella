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
        $locale  = getLocale();
        $withCat = qInt('with_category') === 1;

        if ($id = qInt('id')) {
            $row = DB::fetchOne('SELECT * FROM subcategories WHERE id = ?', 'i', [$id]);
            if (!$row) Response::error('Subcategory not found', 404);
            $row = $this->applyLocale($row, $locale);
            if ($withCat) $row['category'] = $this->getCategory($row['category_id'], $locale);
            Response::success($row);
        }

        if ($slug = qStr('slug')) {
            $row = DB::fetchOne('SELECT * FROM subcategories WHERE slug = ?', 's', [$slug]);
            if (!$row) Response::error('Subcategory not found', 404);
            $row = $this->applyLocale($row, $locale);
            if ($withCat) $row['category'] = $this->getCategory($row['category_id'], $locale);
            Response::success($row);
        }

        if ($catId = qInt('category_id')) {
            [$page, $limit, $offset] = getPagination(10);
            $total = DB::count('subcategories', 'category_id = ?', 'i', [$catId]);
            $rows  = DB::fetchAll(
                'SELECT * FROM subcategories WHERE category_id = ? ORDER BY name ASC LIMIT ? OFFSET ?',
                'iii', [$catId, $limit, $offset]
            );
            $rows = array_map(fn($r) => $this->applyLocale($r, $locale), $rows);
            if ($withCat) {
                $cat = $this->getCategory($catId, $locale);
                foreach ($rows as &$row) $row['category'] = $cat;
            }
            Response::paginated($rows, $total, $page, $limit, 'subcategories');
        }

        [$page, $limit, $offset] = getPagination(10);
        $total = DB::count('subcategories');
        $rows  = DB::fetchAll('SELECT * FROM subcategories ORDER BY name ASC LIMIT ? OFFSET ?', 'ii', [$limit, $offset]);
        $rows  = array_map(fn($r) => $this->applyLocale($r, $locale), $rows);
        Response::paginated($rows, $total, $page, $limit, 'subcategories');
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

        if (DB::fetchOne('SELECT id FROM subcategories WHERE slug = ?', 's', [$slug]))
            Response::error('Slug already in use', 409);

        if (DB::fetchOne('SELECT id FROM subcategories WHERE name = ? AND category_id = ?', 'si', [$name, $categoryId]))
            Response::error('Subcategory name already exists in this category', 409);

        $id = DB::insert(
            'INSERT INTO subcategories (name, category_id, slug, image) VALUES (?, ?, ?, ?)',
            'siss',
            [$name, $categoryId, $slug, $image]
        );

        Response::success(['id' => $id], 'Subcategory created');
    }

    // ── PUT /api/subcategories?id=1  (admin) ─────────────────────────────────
    // Body: any of { name, slug, category_id, image }
    public function update(): void
    {
        $id = qInt('id');
        if (!$id) Response::error('id is required', 400);

        $d = jsonBody();

        $current = DB::fetchOne('SELECT * FROM subcategories WHERE id = ?', 'i', [$id]);
        if (!$current) Response::error('Subcategory not found', 404);

        // Remove fields that haven't changed
        foreach (['name', 'slug', 'image'] as $f) {
            if (isset($d[$f]) && (string)$d[$f] === (string)$current[$f]) unset($d[$f]);
        }
        if (isset($d['category_id']) && (int)$d['category_id'] === (int)$current['category_id']) unset($d['category_id']);

        [$fields, $types, $values] = buildUpdate($d, [
            'name'        => 's',
            'slug'        => 's',
            'category_id' => 'i',
            'image'       => 's',
        ]);

        if (empty($fields)) Response::success(null, 'Nothing to update, values are the same');

        if (isset($d['slug'])) {
            if (DB::fetchOne('SELECT id FROM subcategories WHERE slug = ? AND id != ?', 'si', [$d['slug'], $id]))
                Response::error('Slug already in use', 409);
        }

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

        if (!DB::fetchOne('SELECT id FROM subcategories WHERE id = ?', 'i', [$id]))
            Response::error('Subcategory not found', 404);

        DB::execute('DELETE FROM subcategories WHERE id = ?', 'i', [$id]);
        Response::success(null, 'Subcategory deleted');
    }

    // ── Private helper ────────────────────────────────────────────────────────
    private function applyLocale(array $row, string $locale): array
    {
        if ($locale !== 'en') {
            $row['name'] = $row["name_{$locale}"] ?: $row['name'];
        }
        unset($row['name_rw'], $row['name_fr'], $row['name_sw']);
        return $row;
    }

    private function getCategory(int $id, string $locale = 'en'): ?array
    {
        $row = DB::fetchOne('SELECT * FROM categories WHERE id = ?', 'i', [$id]);
        if ($row) {
            if ($locale !== 'en') {
                $row['title']       = $row["title_{$locale}"] ?: $row['title'];
                $row['description'] = $row["description_{$locale}"] ?: $row['description'];
            }
            unset($row['title_rw'], $row['title_fr'], $row['title_sw'], $row['description_rw'], $row['description_fr'], $row['description_sw']);
        }
        return $row;
    }
}
