<?php
// Deprecated — all DB access goes through core/DB.php
require_once __DIR__ . '/../core/Response.php';
Response::error('Direct connection file is deprecated', 410);
