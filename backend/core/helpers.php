<?php

/**
 * Read page/limit from $_GET and return [page, limit, offset]
 * @param int $defaultLimit
 */
function getPagination(int $defaultLimit = 16): array
{
    $page   = max(1, (int) ($_GET['page']  ?? 1));
    $limit  = max(1, min((int) ($_GET['limit'] ?? $defaultLimit), 100));
    $offset = ($page - 1) * $limit;

    return [$page, $limit, $offset];
}

/**
 * Read and sanitise a string query param
 */
function qStr(string $key, string $default = ''): string
{
    return trim($_GET[$key] ?? $default);
}

/**
 * Read and sanitise an integer query param
 */
function qInt(string $key, int $default = 0): int
{
    return (int) ($_GET[$key] ?? $default);
}

/**
 * Read JSON body once and return array
 */
function jsonBody(): array
{
    static $body = null;
    if ($body === null) {
        $body = json_decode(file_get_contents('php://input'), true) ?? [];
    }
    return $body;
}

/**
 * Build a dynamic SET clause for UPDATE queries
 */
function buildUpdate(array $data, array $fieldMap): array
{
    $fields = [];
    $types  = '';
    $values = [];

    foreach ($fieldMap as $col => $type) {
        if (array_key_exists($col, $data)) {
            $fields[] = "`$col` = ?";
            $types   .= $type;
            $values[] = $type === 'i' ? (int) $data[$col] : (string) $data[$col];
        }
    }

    return [$fields, $types, $values];
}

/**
 * Encrypt a plain string using AES-256-CBC
 */
function encrypt(string $value): string
{
    require_once __DIR__ . '/Env.php';
    loadEnv(__DIR__ . '/../.env');
    $key = hex2bin(env('ENCRYPTION_KEY'));
    $iv  = random_bytes(16);
    $enc = openssl_encrypt($value, 'AES-256-CBC', $key, OPENSSL_RAW_DATA, $iv);
    return base64_encode($iv . $enc);
}

/**
 * Decrypt an encrypted string
 */
function decrypt(string $value): string
{
    require_once __DIR__ . '/Env.php';
    loadEnv(__DIR__ . '/../.env');
    $raw = base64_decode($value, true);
    if ($raw === false || strlen($raw) <= 16) return $value; // not encrypted
    $key = hex2bin(env('ENCRYPTION_KEY'));
    $iv  = substr($raw, 0, 16);
    $enc = substr($raw, 16);
    if (strlen($iv) !== 16) return $value;
    $result = openssl_decrypt($enc, 'AES-256-CBC', $key, OPENSSL_RAW_DATA, $iv);
    return $result !== false ? $result : $value;
}

/**
 * Deterministic HMAC hash for DB lookup (email)
 */
function emailHash(string $email): string
{
    require_once __DIR__ . '/Env.php';
    loadEnv(__DIR__ . '/../.env');
    return hash_hmac('sha256', strtolower(trim($email)), env('ENCRYPTION_KEY'));
}

/**
 * Get the request locale from Accept-Language header (en, rw, fr)
 */
function getLocale(): string
{
    $supported = ['en', 'rw', 'fr'];
    $header    = $_SERVER['HTTP_ACCEPT_LANGUAGE'] ?? 'en';
    $lang      = strtolower(substr(trim(explode(',', $header)[0]), 0, 2));
    return in_array($lang, $supported) ? $lang : 'en';
}
