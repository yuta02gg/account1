<?php
// includes/db.php
$servername = "localhost";
$username = "tanaka";         // 新しいユーザー名
$password = "hNS7OLeIYydQDd0V";  // 新しいパスワード
$dbname = "account";    // 使用するデータベース名

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>
