<?php

require_once __DIR__ . '/../core/DB.php';
require_once __DIR__ . '/../core/Response.php';
require_once __DIR__ . '/../core/helpers.php';

class UserController
{
    // ── GET /api/users  (admin) ──────────────────────────────────────────────
    public function index(): void
    {
        [$page, $limit, $offset] = getPagination(20);

        $total = DB::count('users');
        $rows  = DB::fetchAll(
            'SELECT id, name, email, phone, role, created_at FROM users ORDER BY id DESC LIMIT ? OFFSET ?',
            'ii', [$limit, $offset]
        );

        Response::paginated($rows, $total, $page, $limit, 'users');
    }

    // ── GET /api/users/profile?id=1  (auth) ──────────────────────────────────
    // User can only view their own profile. Admin can view any.
    public function profile(array $authUser): void
    {
        $id = qInt('id');
        if (!$id) Response::error('id is required', 400);

        if ($authUser['role'] !== 'admin' && $authUser['id'] !== $id) {
            Response::error('Forbidden', 403);
        }

        $user = DB::fetchOne(
            'SELECT id, name, email, phone, role, created_at FROM users WHERE id = ?',
            'i', [$id]
        );

        if (!$user) Response::error('User not found', 404);
        Response::success($user);
    }

    // ── PUT /api/users/profile?id=1  (auth) ──────────────────────────────────
    // User can only update their own profile. Admin can update any.
    public function updateProfile(array $authUser): void
    {
        $id = qInt('id');
        if (!$id) Response::error('id is required', 400);

        if ($authUser['role'] !== 'admin' && $authUser['id'] !== $id) {
            Response::error('Forbidden', 403);
        }

        [$fields, $types, $values] = buildUpdate(jsonBody(), [
            'name'  => 's',
            'phone' => 's',
        ]);

        if (empty($fields)) Response::error('No fields to update', 400);

        DB::execute(
            'UPDATE users SET ' . implode(', ', $fields) . ' WHERE id = ?',
            $types . 'i',
            array_merge($values, [$id])
        );

        Response::success(null, 'Profile updated');
    }

    // ── DELETE /api/users?id=1  (admin) ──────────────────────────────────────
    public function destroy(): void
    {
        $id = qInt('id');
        if (!$id) Response::error('id is required', 400);

        DB::execute('DELETE FROM users WHERE id = ?', 'i', [$id]);
        Response::success(null, 'User deleted');
    }
}
