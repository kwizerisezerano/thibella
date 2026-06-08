<?php

require_once __DIR__ . '/../core/Env.php';
loadEnv(__DIR__ . '/../.env');

return [
    'host'     => env('DB_HOST', 'localhost'),
    'user'     => env('DB_USER', 'root'),
    'password' => env('DB_PASSWORD', ''),
    'database' => env('DB_NAME', 'thibella_db'),
];
