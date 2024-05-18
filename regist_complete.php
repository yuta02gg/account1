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
        $stmt = $conn->prepare("INSERT INTO accounts (family_name, last_name, family_name_kana, last_name_kana, mail, password, gender, postal_code, prefecture, address_1, address_2, authority) 
                                VALUES (:family_name, :last_name, :family_name_kana, :last_name_kana, :mail, :password, :gender, :postal_code, :prefecture, :address_1, :address_2, :authority)");

        $stmt->bindParam(':family_name', $family_name);
        $stmt->bindParam(':last_name', $last_name);
        $stmt->bindParam(':family_name_kana', $family_name_kana);
        $stmt->bindParam(':last_name_kana', $last_name_kana);
        $stmt->bindParam(':mail', $mail);
        $stmt->bindParam(':password', password_hash($password, PASSWORD_DEFAULT));
        $stmt->bindParam(':gender', $gender);
        $stmt->bindParam(':postal_code', $postal_code);
        $stmt->bindParam(':prefecture', $prefecture);
        $stmt->bindParam(':address_1', $address_1);
        $stmt->bindParam(':address_2', $address_2);
        $stmt->bindParam(':authority', $authority);

        $stmt->execute();

        // セッションデータの削除
        unset($_SESSION['family_name']);
        unset($_SESSION['last_name']);
        unset($_SESSION['family_name_kana']);
        unset($_SESSION['last_name_kana']);
        unset($_SESSION['mail']);
        unset($_SESSION['password']);
        unset($_SESSION['gender']);
        unset($_SESSION['postal_code']);
        unset($_SESSION['prefecture']);
        unset($_SESSION['address_1']);
        unset($_SESSION['address_2']);
        unset($_SESSION['authority']);

        header("Location: regist_complete.php");
        exit();
    } catch(PDOException $e) {
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
        .container {
            width: 80%;
            margin: 0 auto;
            text-align: center;
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
        }
        .main p {
            font-size: 20px;
            margin-bottom: 30px;
        }
        .button {
            display: inline-block;
            padding: 10px 20px;
            font-size: 16px;
            color: #fff;
            background-color: #007bff;
            text-decoration: none;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>アカウント登録完了画面</h1>
        </div>
        <div class="main">
            <p>登録完了しました</p>
            <a class="button" href="index.html">TOPページへ戻る</a>
        </div>
        <div class="footer">
            <p>&copy; 2024 Your Company</p>
        </div>
    </div>
</body>
</html>
