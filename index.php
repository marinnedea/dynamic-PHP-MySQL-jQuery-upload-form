<?php
session_start();
if (!isset($_SESSION['user']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

require 'config.php';

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['file'])) {
    $allowed_types = ['image/jpeg', 'image/png', 'image/gif', 'application/pdf'];
    $max_size = 5 * 1024 * 1024; // 5 MB

    $file = $_FILES['file'];

    if ($file['error'] !== UPLOAD_ERR_OK) {
        $message = "Upload error (code {$file['error']}).";
    } elseif (!in_array(mime_content_type($file['tmp_name']), $allowed_types)) {
        $message = "File type not allowed. Accepted: JPEG, PNG, GIF, PDF.";
    } elseif ($file['size'] > $max_size) {
        $message = "File too large. Maximum size is 5 MB.";
    } else {
        $uploadDir = 'uploads/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        $safeName = basename($file['name']);
        if (move_uploaded_file($file['tmp_name'], $uploadDir . $safeName)) {
            $pdo->prepare("INSERT INTO uploads (filename) VALUES (?)")->execute([$safeName]);
            $message = "File uploaded successfully.";
        } else {
            $message = "Failed to move uploaded file.";
        }
    }
}

$files = $pdo->query("SELECT filename FROM uploads ORDER BY id DESC")->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Area</title>
</head>
<body>
    <h1>Admin Area</h1>

    <?php if ($message): ?>
        <p><?= htmlspecialchars($message) ?></p>
    <?php endif; ?>

    <form method="post" enctype="multipart/form-data">
        <label for="file">Choose file:</label>
        <input type="file" name="file" id="file" required>
        <button type="submit">Upload</button>
    </form>

    <h2>Uploaded Files</h2>
    <ul>
        <?php foreach ($files as $row): ?>
            <li><?= htmlspecialchars($row['filename']) ?></li>
        <?php endforeach; ?>
    </ul>

    <a href="logout.php">Logout</a>
</body>
</html>
