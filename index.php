php 
<?php 
require 'db.php'; 
 
$stmt = $pdo->query("SELECT * FROM events ORDER BY id DESC"); 
$events = $stmt->fetchAll(PDO::FETCH_ASSOC); 
?> 
<!DOCTYPE html> 
<html> 
<head><meta charset="utf-8"><title>活動清單</title></head> 
<body> 
    <h1>廢墟版活動報名平台</h1> 
    <p><a href="create_event.php">+ 新增新的活動</a></p> 
    <hr> 
    <h2>活動清單</h2> 
    <ul> 
        <?php foreach ($events as $event): ?> 
            <li> 
                <strong><?= htmlspecialchars($event['title']) ?></strong> - <?= htmlspecialchars($event['description']) ?> 
                | <a href="register.php?event_id=<?= $event['id'] ?>">點擊報名</a> 
                | <a href="view_registrations.php?event_id=<?= $event['id'] ?>">查看報名清單</a> 
            </li> 
        <?php endforeach; ?> 
    </ul> 
</body> 
</html>