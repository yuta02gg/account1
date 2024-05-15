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
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>アカウント登録完了</title>
    <style type="text/css">
        body {
            font-family: Arial, sans-serif;
            text-align: center;
        }
        .container {
            width: 300px;
            margin: 50px auto;
        }
        button {
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
        }
        button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div class="container">
        <p>登録完了しました</p>
        <a href="index.html">
            <button>TOPページへ戻る</button>
        </a>
    </div>
</body>
</html>
