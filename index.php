<?php
session_start();
if (!isset($_SESSION['user']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

require 'config.php';

$errors   = [];
$success  = 0;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $first_names = $_POST['first_name'] ?? [];
    $last_names  = $_POST['last_name']  ?? [];
    $emails      = $_POST['email']      ?? [];
    $files       = $_FILES['file']      ?? [];

    $allowed_types = ['image/jpeg', 'image/png', 'image/gif', 'application/pdf'];
    $max_size      = 5 * 1024 * 1024;
    $upload_dir    = __DIR__ . '/uploads/';

    if (!is_dir($upload_dir)) mkdir($upload_dir, 0755, true);

    $count = count($first_names);
    for ($i = 0; $i < $count; $i++) {
        $row_label  = 'Row ' . ($i + 1);
        $first_name = trim($first_names[$i]);
        $last_name  = trim($last_names[$i]);
        $email      = trim($emails[$i]);

        if ($first_name === '' || $last_name === '' || $email === '') {
            $errors[] = "$row_label: all fields are required.";
            continue;
        }

        if ($files['error'][$i] !== UPLOAD_ERR_OK) {
            $errors[] = "$row_label: no file selected or upload error.";
            continue;
        }

        if (!in_array(mime_content_type($files['tmp_name'][$i]), $allowed_types)) {
            $errors[] = "$row_label: file type not allowed (JPEG, PNG, GIF, PDF only).";
            continue;
        }

        if ($files['size'][$i] > $max_size) {
            $errors[] = "$row_label: file exceeds 5 MB limit.";
            continue;
        }

        $ext      = strtolower(pathinfo($files['name'][$i], PATHINFO_EXTENSION));
        $filename = uniqid('file_', true) . '.' . $ext;

        if (move_uploaded_file($files['tmp_name'][$i], $upload_dir . $filename)) {
            $pdo->prepare("INSERT INTO uploads (first_name, last_name, email, filename) VALUES (?, ?, ?, ?)")
                ->execute([$first_name, $last_name, $email, $filename]);
            $success++;
        } else {
            $errors[] = "$row_label: failed to save file.";
        }
    }
}

$uploads = $pdo->query("SELECT first_name, last_name, email, filename, uploaded_at FROM uploads ORDER BY id DESC")->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Form</title>
    <style>
        * { box-sizing: border-box; }
        body { font-family: sans-serif; margin: 0; background: #f5f5f5; }
        nav {
            background: #1a1a2e;
            color: #fff;
            padding: 0 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            height: 52px;
        }
        nav .nav-title { font-weight: 700; font-size: 1rem; letter-spacing: 0.02em; }
        nav .nav-user  { font-size: 0.85rem; color: #aab4c4; }
        nav a.nav-logout {
            margin-left: 16px;
            color: #cdd3de;
            text-decoration: none;
            font-size: 0.85rem;
            padding: 5px 12px;
            border: 1px solid rgba(255,255,255,0.25);
            border-radius: 5px;
            transition: background 0.15s;
        }
        nav a.nav-logout:hover { background: rgba(255,255,255,0.1); color: #fff; }
        .page { margin: 30px; }
        #rows-container { margin: 16px 0; }
        .upload-row { display: flex; align-items: center; gap: 8px; margin-bottom: 8px; }
        .row-num { width: 24px; text-align: right; font-weight: bold; color: #555; flex-shrink: 0; }
        .upload-row input[type="text"],
        .upload-row input[type="email"] { padding: 5px 8px; width: 140px; }
        .upload-row input[type="file"] { width: 200px; }
        button { padding: 6px 14px; cursor: pointer; }
        .btn-remove { background: #e53e3e; color: #fff; border: none; border-radius: 4px; }
        .btn-remove:hover { background: #c53030; }
        #btn-add { margin-bottom: 8px; }
        .messages { margin: 12px 0; }
        .msg-success { color: #065f46; background: #d1fae5; padding: 8px 12px; border-radius: 4px; }
        .msg-error   { color: #991b1b; background: #fee2e2; padding: 8px 12px; border-radius: 4px; margin-top: 4px; }
        table { border-collapse: collapse; margin-top: 16px; width: 100%; }
        th, td { border: 1px solid #ddd; padding: 8px 12px; text-align: left; font-size: 0.9rem; }
        th { background: #f0f0f0; }
    </style>
</head>
<body>
    <nav>
        <span class="nav-title">Upload Form</span>
        <span>
            <span class="nav-user">Logged in as <?= htmlspecialchars($_SESSION['user']) ?></span>
            <a href="logout.php" class="nav-logout">Logout</a>
        </span>
    </nav>
    <div class="page">
    <h1>Upload Form</h1>

    <?php if ($success > 0): ?>
        <div class="messages">
            <div class="msg-success"><?= $success ?> row<?= $success > 1 ? 's' : '' ?> uploaded successfully.</div>
        </div>
    <?php endif; ?>
    <?php if ($errors): ?>
        <div class="messages">
            <?php foreach ($errors as $e): ?>
                <div class="msg-error"><?= htmlspecialchars($e) ?></div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <button type="button" id="btn-add">Add row</button>

    <form method="post" enctype="multipart/form-data" id="upload-form">
        <div id="rows-container"></div>
        <button type="submit">Submit</button>
    </form>

    <h2>Uploaded Files</h2>
    <?php if ($uploads): ?>
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Email</th>
                    <th>File</th>
                    <th>Uploaded</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($uploads as $i => $row): ?>
                    <tr>
                        <td><?= $i + 1 ?></td>
                        <td><?= htmlspecialchars($row['first_name']) ?></td>
                        <td><?= htmlspecialchars($row['last_name']) ?></td>
                        <td><?= htmlspecialchars($row['email']) ?></td>
                        <td><?= htmlspecialchars($row['filename']) ?></td>
                        <td><?= $row['uploaded_at'] ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No uploads yet.</p>
    <?php endif; ?>

    </div><!-- /.page -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script>
        function updateRowNumbers() {
            $('#rows-container .upload-row').each(function (index) {
                $(this).find('.row-num').text(index + 1);
            });
        }

        function addRow() {
            var row = $(
                '<div class="upload-row">' +
                    '<span class="row-num"></span>' +
                    '<input type="text"  name="first_name[]" placeholder="First Name" required>' +
                    '<input type="text"  name="last_name[]"  placeholder="Last Name"  required>' +
                    '<input type="email" name="email[]"      placeholder="Email"       required>' +
                    '<input type="file"  name="file[]"       accept=".jpg,.jpeg,.png,.gif,.pdf" required>' +
                    '<button type="button" class="btn-remove">Remove</button>' +
                '</div>'
            );
            $('#rows-container').append(row);
            updateRowNumbers();
        }

        $('#btn-add').on('click', addRow);

        $(document).on('click', '.btn-remove', function () {
            $(this).closest('.upload-row').remove();
            updateRowNumbers();
        });

        // Start with one row
        addRow();
    </script>
</body>
</html>
