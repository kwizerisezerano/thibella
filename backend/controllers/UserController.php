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

        $rows = array_map(function ($u) {
            $u['name']  = decrypt($u['name']);
            $u['email'] = decrypt($u['email']);
            $u['phone'] = decrypt($u['phone']);
            return $u;
        }, $rows);

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
        $user['name']  = decrypt($user['name']);
        $user['email'] = decrypt($user['email']);
        $user['phone'] = decrypt($user['phone']);
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

        $body = jsonBody();
        if (isset($body['name']))  $body['name']  = encrypt($body['name']);
        if (isset($body['phone'])) $body['phone'] = encrypt($body['phone']);

        [$fields, $types, $values] = buildUpdate($body, [
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
