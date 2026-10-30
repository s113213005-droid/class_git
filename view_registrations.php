
<?php
require 'db.php';

// 取得活動 ID，同時支援 event_id 和 id
$eventId = $_GET['event_id'] ?? $_GET['id'] ?? null;

if (!$eventId) {
    die("未指定活動 ID");
}

// 撈取活動資訊
$stmtEvent = $pdo->prepare("SELECT title FROM events WHERE id = ?");
$stmtEvent->execute([$eventId]);
$event = $stmtEvent->fetch(PDO::FETCH_ASSOC);

// 檢查活動是否存在
if (!$event) {
    die("找不到此活動");
}

// 撈取報名者名單
$stmt = $pdo->prepare(
    "SELECT * FROM registrations WHERE event_id = ? ORDER BY id DESC"
);
$stmt->execute([$eventId]);
$registrations = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>報名清單</title>
</head>
<body>

    <h2>活動【<?= htmlspecialchars($event['title'], ENT_QUOTES, 'UTF-8') ?>】的報名清單</h2>

    <table border="1" cellpadding="5">
        <tr>
            <th>姓名</th>
            <th>連絡電話</th>
        </tr>

        <?php foreach ($registrations as $row): ?>
            <tr>
                <td><?= htmlspecialchars($row['name'], ENT_QUOTES, 'UTF-8') ?></td>
                <td><?= htmlspecialchars($row['phone'], ENT_QUOTES, 'UTF-8') ?></td>
            </tr>
        <?php endforeach; ?>
    </table>

    <?php if (count($registrations) == 0): ?>
        <p>目前尚無報名人員。</p>
    <?php endif; ?>

    <br>
    <a href="index.php">回活動清單</a>

</body>
</html>
