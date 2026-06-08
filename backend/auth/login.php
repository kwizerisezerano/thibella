<?php
// This file is deprecated. All auth is handled via /api/auth/login
require_once __DIR__ . '/../core/Response.php';
Response::error('Use POST /api/auth/login instead', 410);
