<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'] ?? '';
    $description = $_POST['description'] ?? '';

    if (!empty($title)) {
        $stmt = $pdo->prepare("INSERT INTO events (title, description) VALUES (?, ?)");
        $stmt->execute([$title, $description]);
        header("Location: index.php");
        exit;
    }
}
?>
<!DOCTYPE html>
<html>
<head><meta charset="utf-8"><title>新增活動</title></head>
<body>
    <h2>新增活動</h2>
    <form method="POST">
        活動名稱：<input type="text" name="title" required><br><br>
        活動內容：<textarea name="description"></textarea><br><br>
        <button type="submit">送出新增</button>
    </form>
    <br><a href="index.php">回活動清單</a>
</body>
</html>