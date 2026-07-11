<?php

/**
 * Load .env file into $_ENV once.
 * Supports KEY=VALUE, ignores comments (#) and blank lines.
 */
function loadEnv(string $path): void
{
    static $loaded = false;
    if ($loaded) return;

    if (!file_exists($path)) {
        throw new RuntimeException(".env file not found at: $path");
    }

    foreach (file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $line) {
        $trimmed = trim($line);
        if ($trimmed === '' || $trimmed[0] === '#' || strpos($line, '=') === false) continue;
        list($key, $value) = explode('=', $line, 2);
        $_ENV[trim($key)] = trim($value);
    }

    $loaded = true;
}

/**
 * @param mixed $default
 * @return mixed
 */
function env(string $key, $default = null)
{
    return $_ENV[$key] ?? $default;
}
