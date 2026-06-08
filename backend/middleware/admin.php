<?php

require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/../core/Response.php';

if ($authUser['role'] !== 'admin') {
    Response::error('Admin access required', 403);
}
