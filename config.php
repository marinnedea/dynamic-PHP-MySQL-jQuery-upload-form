<?php

// ============================================================
// Database — set via environment variables.
// For Apache add to your VirtualHost:
//   SetEnv DB_HOST localhost
//   SetEnv DB_USER uploaduser
//   SetEnv DB_PASS secret
//   SetEnv DB_NAME uploaddb
//
// For Nginx set in your PHP-FPM pool (/etc/php/x.x/fpm/pool.d/app.conf):
//   env[DB_HOST] = localhost
//   env[DB_USER] = uploaduser
//   env[DB_PASS] = secret
//   env[DB_NAME] = uploaddb
// ============================================================

$dsn = 'mysql:host=' . getenv('DB_HOST') . ';dbname=' . getenv('DB_NAME') . ';charset=utf8mb4';

try {
    $pdo = new PDO($dsn, getenv('DB_USER'), getenv('DB_PASS'), [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ]);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
