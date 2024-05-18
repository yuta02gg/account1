<?php
include 'includes/db.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION['family_name'])) {
    $family_name = $_SESSION['family_name'];
    $last_name = $_SESSION['last_name'];
    $family_name_kana = $_SESSION['family_name_kana'];
    $last_name_kana = $_SESSION['last_name_kana'];
    $mail = $_SESSION['mail'];
    $password = $_SESSION['password'];
    $gender = $_SESSION['gender'];
    $postal_code = $_SESSION['postal_code'];
    $prefecture = $_SESSION['prefecture'];
    $address_1 = $_SESSION['address_1'];
    $address_2 = $_SESSION['address_2'];
    $authority = $_SESSION['authority'];

    try {
        $conn = getDbConnection(); // データベース接続を取得
        $stmt = $conn->prepare("INSERT INTO accounts (family_name, last_name, family_name_kana, last_name_kana, mail, password, gender, postal_code, prefecture, address_1, address_2, authority, delete_flag, registered_time, update_time) 
                                VALUES (:family_name, :last_name, :family_name_kana, :last_name_kana, :mail, :password, :gender, :postal_code, :prefecture, :address_1, :address_2, :authority, 0, NOW(), NOW())");

        $stmt->bindParam(':family_name', $family_name);
        $stmt->bindParam(':last_name', $last_name);
        $stmt->bindParam(':family_name_kana', $family_name_kana);
        $stmt->bindParam(':last_name_kana', $last_name_kana);
        $stmt->bindParam(':mail', $mail);
        $stmt->bindParam(':password', password_hash($password, PASSWORD_DEFAULT)); // パスワードはハッシュ化
        $stmt->bindParam(':gender', $gender);
        $stmt->bindParam(':postal_code', $postal_code);
        $stmt->bindParam(':prefecture', $prefecture);
        $stmt->bindParam(':address_1', $address_1);
        $stmt->bindParam(':address_2', $address_2);
        $stmt->bindParam(':authority', $authority);

        $stmt->execute();

        // セッションデータの削除
        session_unset();
        session_destroy();

        header("Location: regist_complete.php");
        exit();
    } catch (PDOException $e) {
        echo "エラーが発生したためアカウント登録できません: " . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>アカウント登録完了画面</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .header, .footer {
            padding: 20px;
            background-color: #f8f8f8;
            border-bottom: 1px solid #ddd;
        }
        .header {
            border-top: 1px solid #ddd;
        }
        .main {
            padding: 50px 0;
            text-align: center;
        }
        .main p {
            font-size: 24px;
            margin-bottom: 30px;
        }
        .main a {
            display: inline-block;
            padding: 10px 20px;
            font-size: 16px;
            color: #fff;
            background-color: #007bff;
            text-decoration: none;
            border-radius: 5px;
        }
        .main a:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="header">
        <p>ナビゲーションバー</p>
    </div>
    <div class="container">  
        <h1>アカウント登録完了画面</h1>
        <div class="main">
            <p>登録完了しました</p>
            <a href="index.html">TOPページへ戻る</a>
        </div>
    </div>
    <div class="footer">
        <p>フッター</p>
    </div>
</body>
</html>
