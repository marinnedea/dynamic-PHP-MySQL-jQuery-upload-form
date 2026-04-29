<?php
session_start();

// Only an existing admin can create new admin accounts.
// To bootstrap the very first admin: temporarily comment out these 3 lines,
// register once, then uncomment them again.
if (!isset($_SESSION['user']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

require 'config.php';

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pdo->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, 'admin')")
        ->execute([
            $_POST['username'],
            password_hash($_POST['password'], PASSWORD_DEFAULT),
        ]);
    $message = "Admin user created successfully.";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Admin</title>
</head>
<body>
    <h1>Register Admin</h1>
    <?php if ($message): ?>
        <p><?= htmlspecialchars($message) ?></p>
    <?php endif; ?>
    <form method="post">
        <label for="username">Username:</label>
        <input type="text" name="username" id="username" required>
        <br>
        <label for="password">Password:</label>
        <input type="password" name="password" id="password" required>
        <br>
        <button type="submit">Register</button>
    </form>
    <a href="index.php">Back</a>
</body>
</html>
