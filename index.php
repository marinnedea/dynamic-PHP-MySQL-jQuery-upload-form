<?php
// Start session
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: admin.php");
    exit;
}

$dsn = 'mysql:host=your_host;dbname=your_database';
$username = 'your_username';
$password = 'your_password';

try {
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['file'])) {
    $fileName = $_FILES['file']['name'];
    $fileTmp = $_FILES['file']['tmp_name'];
    $uploadDir = 'uploads/';

    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }

    $uploadPath = $uploadDir . basename($fileName);
    if (move_uploaded_file($fileTmp, $uploadPath)) {
        $stmt = $pdo->prepare("INSERT INTO uploads (filename) VALUES (:filename)");
        $stmt->execute([':filename' => $fileName]);
        echo "File uploaded successfully.";
    } else {
        echo "Failed to upload file.";
    }
}

$files = $pdo->query("SELECT * FROM uploads")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Form</title>
</head>
<body>
    <h1>Upload Form</h1>
    <form method="post" enctype="multipart/form-data">
        <label for="file">Choose file:</label>
        <input type="file" name="file" id="file" required>
        <button type="submit">Upload</button>
    </form>

    <h2>Uploaded Files</h2>
    <ul>
        <?php foreach ($files as $file): ?>
            <li><?= htmlspecialchars($file['filename']) ?></li>
        <?php endforeach; ?>
    </ul>

    <a href="logout.php">Logout</a>
</body>
</html>
