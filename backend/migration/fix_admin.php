<?php
require_once __DIR__ . '/../core/Env.php';
require_once __DIR__ . '/../core/helpers.php';
loadEnv(__DIR__ . '/../.env');

$host     = env('DB_HOST', 'localhost');
$user     = env('DB_USER', 'root');
$password = env('DB_PASSWORD', '');
$database = env('DB_NAME', 'thibella_db');

$conn = new mysqli($host, $user, $password, $database);
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);
$conn->set_charset('utf8mb4');

$emailPlain = strtolower(trim(env('ADMIN_EMAIL', 'admin@thibella.com')));

$encName   = encrypt(env('ADMIN_NAME', 'Thibella'));
$encEmail  = encrypt($emailPlain);
$encPhone  = encrypt(env('ADMIN_PHONE', '+250700000000'));
$emailHash = emailHash($emailPlain);

// Drop the plain-text unique key on email first, then update
$conn->query("ALTER TABLE `users` DROP INDEX IF EXISTS `email`");

$stmt = $conn->prepare(
    "UPDATE `users` SET name = ?, email = ?, phone = ?, email_hash = ? WHERE role = 'admin'"
);
$stmt->bind_param('ssss', $encName, $encEmail, $encPhone, $emailHash);
$stmt->execute();
echo "Affected rows: " . $stmt->affected_rows . "\n";
$stmt->close();

// Mark 011 as ran if not already
$conn->query("INSERT IGNORE INTO `_migrations` (name) VALUES ('011_encrypt_admin_user')");

$conn->close();
echo "Done.\n";
