<?php
require 'db.php';

$error = '';
$title = '';
$description = '';
$eventDate = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $eventDate = trim($_POST['event_date'] ?? '');

    if ($title === '') {
        $error = '請輸入活動名稱！';
    } elseif (mb_strlen($title) > 100) {
        $error = '活動名稱長度不可超過 100 個字！';
    } else {
        try {
            $stmt = $pdo->prepare(
                "INSERT INTO events (title, description, event_date) VALUES (?, ?, ?)"
            );
            $stmt->execute([
                $title,
                $description !== '' ? $description : null,
                $eventDate !== '' ? $eventDate : null
            ]);

            header("Location: index.php");
            exit;
        } catch (PDOException $e) {
            $error = '新增活動失敗，資料庫寫入發生錯誤，請稍後再試！';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="zh-Hant">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>新增活動</title>
    <style>
        body {
            font-family: Arial, "Microsoft JhengHei", sans-serif;
            background: #f5f5f5;
            margin: 0;
            padding: 30px;
        }
        .container {
            max-width: 500px;
            margin: 40px auto;
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 3px 12px rgba(0,0,0,0.1);
        }
        h2 {
            text-align: center;
        }
        label {
            display: block;
            margin: 15px 0 8px;
            font-weight: bold;
        }
        input[type="text"], input[type="datetime-local"], textarea {
            width: 100%;
            padding: 10px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 16px;
        }
        textarea {
            height: 100px;
            resize: vertical;
        }
        button {
            width: 100%;
            margin-top: 25px;
            padding: 12px;
            background: #4a83d8;
            color: white;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            cursor: pointer;
        }
        button:hover {
            background: #3268b8;
        }
        .error {
            color: #d93025;
            background: #fff0f0;
            padding: 10px;
            border-radius: 6px;
            margin-bottom: 15px;
        }
        .back {
            display: block;
            text-align: center;
            margin-top: 20px;
            color: #4a83d8;
            text-decoration: none;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>新增活動</h2>

    <?php if ($error !== ''): ?>
        <p class="error"><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></p>
    <?php endif; ?>

    <form method="POST">
        <label for="title">活動名稱：</label>
        <input
            type="text"
            id="title"
            name="title"
            placeholder="請輸入活動名稱"
            maxlength="100"
            value="<?= htmlspecialchars($title, ENT_QUOTES, 'UTF-8') ?>"
            required
        >

        <label for="event_date">活動日期：</label>
        <input
            type="datetime-local"
            id="event_date"
            name="event_date"
            value="<?= htmlspecialchars($eventDate, ENT_QUOTES, 'UTF-8') ?>"
        >

        <label for="description">活動內容：</label>
        <textarea
            id="description"
            name="description"
            placeholder="請輸入活動內容或說明"
        ><?= htmlspecialchars($description, ENT_QUOTES, 'UTF-8') ?></textarea>

        <button type="submit">送出新增</button>
    </form>

    <a class="back" href="index.php">← 回活動清單</a>
</div>
</body>
</html>
