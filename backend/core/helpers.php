<?php

/**
 * Read page/limit from $_GET and return [page, limit, offset]
 * @param int $defaultLimit
 */
function getPagination(int $defaultLimit = 16): array
{
    $page   = max(1, (int) ($_GET['page']  ?? 1));
    $limit  = max(1, min((int) ($_GET['limit'] ?? $defaultLimit), 100)); // cap at 100
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
 * Returns [fields_sql, types, values] or calls Response::error if nothing to update
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
