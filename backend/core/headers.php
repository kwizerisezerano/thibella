<?php

function setCorsHeaders(string $methods = 'GET, POST, PUT, DELETE, OPTIONS'): void
{
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Headers: Content-Type, Authorization');
    header('Content-Type: application/json');
    header("Access-Control-Allow-Methods: $methods");

    if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
        http_response_code(200);
        exit;
    }
}
