
<?php
require 'db.php';

// 接收活動 ID
$eventId = filter_input(INPUT_GET, 'event_id', FILTER_VALIDATE_INT);

if (!$eventId || $eventId <= 0) {
    die("錯誤：未指定有效的活動 ID！");
}

// 查詢活動資料
$stmtEvent = $pdo->prepare(
    "SELECT id, title, description FROM events WHERE id = ?"
);
$stmtEvent->execute([$eventId]);
$event = $stmtEvent->fetch(PDO::FETCH_ASSOC);

if (!$event) {
    die("錯誤：找不到這個活動！");
}

$error = '';

// 接收報名表單
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $name = trim($_POST['name'] ?? '');
    $phone = trim($_POST['phone'] ?? '');

    if ($name === '' || $phone === '') {
        $error = '請完整填寫姓名與聯絡電話！';
    } else {

        // 寫入報名資料
        $stmt = $pdo->prepare(
            "INSERT INTO registrations (event_id, name, phone)
             VALUES (?, ?, ?)"
        );

        $stmt->execute([$eventId, $name, $phone]);

        echo "<script>
            alert('報名成功！');
            window.location.href = 'index.php';
        </script>";
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="zh-Hant">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>活動報名</title>

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

        .event-info {
            background: #f0f5ff;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin: 15px 0 8px;
            font-weight: bold;
        }

        input {
            width: 100%;
            padding: 10px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 16px;
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

    <h2>活動報名表</h2>

    <div class="event-info">
        <strong>活動名稱：</strong>
        <?= htmlspecialchars($event['title'], ENT_QUOTES, 'UTF-8') ?>

        <br><br>

        <strong>活動內容：</strong>
        <?= htmlspecialchars($event['description'] ?? '', ENT_QUOTES, 'UTF-8') ?>
    </div>

    <?php if ($error !== ''): ?>
        <p class="error">
            <?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?>
        </p>
    <?php endif; ?>

    <form method="POST" action="register.php?event_id=<?= $eventId ?>">

        <label for="name">姓名：</label>
        <input
            type="text"
            id="name"
            name="name"
            placeholder="請輸入姓名"
            maxlength="100"
            required
        >

        <label for="phone">聯絡電話：</label>
        <input
            type="tel"
            id="phone"
            name="phone"
            placeholder="請輸入聯絡電話"
            maxlength="30"
            required
        >

        <button type="submit">送出完成報名</button>

    </form>

    <a class="back" href="index.php">← 返回活動清單</a>

</div>
</body>
</html>
