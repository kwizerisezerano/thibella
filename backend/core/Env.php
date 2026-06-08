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
        if (str_starts_with(trim($line), '#') || !str_contains($line, '=')) continue;
        [$key, $value] = explode('=', $line, 2);
        $_ENV[trim($key)] = trim($value);
    }

    $loaded = true;
}

function env(string $key, mixed $default = null): mixed
{
    return $_ENV[$key] ?? $default;
}
