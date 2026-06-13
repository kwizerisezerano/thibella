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

// Widen columns to hold encrypted values
$conn->query("ALTER TABLE `users` MODIFY COLUMN `name`  varchar(500) DEFAULT NULL");
$conn->query("ALTER TABLE `users` MODIFY COLUMN `email` varchar(500) DEFAULT NULL");
$conn->query("ALTER TABLE `users` MODIFY COLUMN `phone` varchar(500) DEFAULT NULL");

// Drop old plain-text unique index on email
$conn->query("ALTER TABLE `users` DROP INDEX IF EXISTS `email`");

$emailPlain = strtolower(trim(env('ADMIN_EMAIL', 'admin@thibella.com')));
$encName    = encrypt(env('ADMIN_NAME', 'Thibella'));
$encEmail   = encrypt($emailPlain);
$encPhone   = encrypt(env('ADMIN_PHONE', '+250700000000'));
$pass       = password_hash(env('ADMIN_PASSWORD', 'Thibella@2025'), PASSWORD_DEFAULT);
$emailHash  = emailHash($emailPlain);

$stmt = $conn->prepare(
    "UPDATE `users` SET name = ?, email = ?, phone = ?, password = ?, email_hash = ? WHERE role = 'admin'"
);
$stmt->bind_param('sssss', $encName, $encEmail, $encPhone, $pass, $emailHash);
$stmt->execute();
echo "Affected rows: " . $stmt->affected_rows . "\n";
$stmt->close();

$conn->query("INSERT IGNORE INTO `_migrations` (name) VALUES ('011_encrypt_admin_user')");

$conn->close();
echo "Done.\n";
