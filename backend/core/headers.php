<?php

function setCorsHeaders(string $methods = 'GET, POST, PUT, DELETE, OPTIONS'): void
{
    // Handle CORS for all origins (more permissive for development)
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Credentials: true');
    header('Access-Control-Max-Age: 86400'); // Cache preflight for 1 day
    
    // Allow common headers
    header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With, Accept, Origin');
    
    // Set content type
    header('Content-Type: application/json; charset=UTF-8');
    
    // Allow methods
    header("Access-Control-Allow-Methods: $methods");
    
    // Handle preflight OPTIONS requests
    if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
        http_response_code(200);
        exit;
    }
}
