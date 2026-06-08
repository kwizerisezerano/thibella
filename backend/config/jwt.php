<?php

require_once __DIR__ . '/../core/Env.php';
loadEnv(__DIR__ . '/../.env');

return [
    'secret_key' => env('JWT_SECRET'),
    'issuer'     => env('JWT_ISSUER', 'thibella-api'),
    'audience'   => env('JWT_AUDIENCE', 'thibella-client'),
    'expiry'     => (int) env('JWT_EXPIRY', 3600),
];
