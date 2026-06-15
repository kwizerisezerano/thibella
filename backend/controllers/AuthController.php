<?php

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../core/DB.php';
require_once __DIR__ . '/../core/Response.php';
require_once __DIR__ . '/../core/helpers.php';

use Firebase\JWT\JWT;

class AuthController
{
    private array $jwt;

    public function __construct()
    {
        $this->jwt = require __DIR__ . '/../config/jwt.php';
    }

    // POST /api/auth/register
    // Body: { name, email, phone, password }
    public function register(): void
    {
        $d = jsonBody();

        if (empty($d['name']) || empty($d['email']) || empty($d['phone']) || empty($d['password'])) {
            Response::error('name, email, phone and password are required', 400);
        }

        $name      = encrypt(trim($d['name']));
        $emailPlain = strtolower(trim($d['email']));
        $email     = encrypt($emailPlain);
        $phone     = encrypt(trim($d['phone']));
        $emailHash = emailHash($emailPlain);
        $password  = password_hash($d['password'], PASSWORD_DEFAULT);
        $allowed   = ['admin', 'user'];
        $role      = in_array($d['role'] ?? '', $allowed) ? $d['role'] : 'user';

        if (DB::fetchOne('SELECT id FROM users WHERE email_hash = ?', 's', [$emailHash])) {
            Response::error('Email already registered', 409);
        }

        DB::insert(
            'INSERT INTO users (name, email, phone, password, role, email_hash) VALUES (?, ?, ?, ?, ?, ?)',
            'ssssss',
            [$name, $email, $phone, $password, $role, $emailHash]
        );

        Response::success(null, 'Registered successfully');
    }

    // POST /api/auth/login
    // Body: { email, password }
    public function login(): void
    {
        $d = jsonBody();

        if (empty($d['email']) || empty($d['password'])) {
            Response::error('login.emailRequired', 400);
        }

        $email     = strtolower(trim($d['email']));
        $emailHash = emailHash($email);
        $user      = DB::fetchOne(
            'SELECT id, name, email, phone, password, role FROM users WHERE email_hash = ?',
            's', [$emailHash]
        );

        if (!$user || !password_verify($d['password'], $user['password'])) {
            Response::error('login.invalidCredentials', 401);
        }

        $now   = time();
        $token = JWT::encode([
            'iss'     => $this->jwt['issuer'],
            'aud'     => $this->jwt['audience'],
            'iat'     => $now,
            'exp'     => $now + $this->jwt['expiry'],
            'user_id' => $user['id'],
            'role'    => $user['role'],
        ], $this->jwt['secret_key'], 'HS256');

        unset($user['password']);
        $user['name']  = decrypt($user['name']);
        $user['email'] = decrypt($user['email']);
        $user['phone'] = decrypt($user['phone']);
        $user['token'] = $token;

        Response::success($user, 'login.success');
    }
}
