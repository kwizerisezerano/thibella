<?php

require_once "auth.php";

if ($authUser['role'] !== 'admin') {
    http_response_code(403);
    echo json_encode(["error" => "Admin access required"]);
    exit;
}
