<?php
// Deprecated — bootstrapping is handled by backend/index.php
require_once __DIR__ . '/../core/Response.php';
Response::error('Direct bootstrap file is deprecated', 410);
