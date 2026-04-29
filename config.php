<?php
$dsn = 'mysql:host=your_host;dbname=your_database;charset=utf8mb4';
$db_user = 'your_username';
$db_pass = 'your_password';

try {
    $pdo = new PDO($dsn, $db_user, $db_pass, [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ]);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
