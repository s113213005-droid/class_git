 
<?php 
$host = 'localhost'; 
$port = '5432'; 
$dbname = 'postgres'; 
$user = 'postgres'; 
$password = 'mo234389'; 
 
$dsn = "pgsql:host=$host;port=$port;dbname=$dbname;"; 
try { 
    $pdo = new PDO($dsn, $user, $password, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]); 
} catch (PDOException $e) { 
    die("資料庫連線失敗: " . $e->getMessage()); 
} 
?>
