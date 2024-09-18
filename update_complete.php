<?php
session_start();
include 'db.php';

// 権限チェック
if (!isset($_SESSION['authority']) || $_SESSION['authority'] != 1) {
    echo 'アクセスが拒否されました。';
    exit;
}
// 変数の初期化
$error_message = '';
$success_message = '';

// CSRFトークンの検証
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        die("Invalid CSRF token");
    }

    $id = $_POST['id'];
    $family_name = $_POST['family_name'];
    $last_name = $_POST['last_name'];
    $family_name_kana = $_POST['family_name_kana'];
    $last_name_kana = $_POST['last_name_kana'];
    $mail = $_POST['mail'];
    $password = $_POST['password'];
    $gender = $_POST['gender'];
    $postal_code = $_POST['postal_code'];
    $prefecture = $_POST['prefecture'];
    $address_1 = $_POST['address_1'];
    $address_2 = $_POST['address_2'];
    $authority = $_POST['authority'];

    try {
        $dbh = getDbConnection();

        // パスワードが空でない場合は更新
        if (!empty($password)) {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $sql = "UPDATE accounts SET family_name = :family_name, last_name = :last_name, family_name_kana = :family_name_kana, 
                    last_name_kana = :last_name_kana, mail = :mail, password = :password, gender = :gender, 
                    postal_code = :postal_code, prefecture = :prefecture, address_1 = :address_1, address_2 = :address_2, 
                    authority = :authority WHERE id = :id";
            $stmt = $dbh->prepare($sql);
            $stmt->bindParam(':password', $hashed_password);
        } else {
            // パスワードが空の場合、パスワードを更新しない
            $sql = "UPDATE accounts SET family_name = :family_name, last_name = :last_name, family_name_kana = :family_name_kana, 
                    last_name_kana = :last_name_kana, mail = :mail, gender = :gender, 
                    postal_code = :postal_code, prefecture = :prefecture, address_1 = :address_1, address_2 = :address_2, 
                    authority = :authority WHERE id = :id";
            $stmt = $dbh->prepare($sql);
        }

        // 共通のパラメータバインド
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':family_name', $family_name);
        $stmt->bindParam(':last_name', $last_name);
        $stmt->bindParam(':family_name_kana', $family_name_kana);
        $stmt->bindParam(':last_name_kana', $last_name_kana);
        $stmt->bindParam(':mail', $mail);
        $stmt->bindParam(':gender', $gender);
        $stmt->bindParam(':postal_code', $postal_code);
        $stmt->bindParam(':prefecture', $prefecture);
        $stmt->bindParam(':address_1', $address_1);
        $stmt->bindParam(':address_2', $address_2);
        $stmt->bindParam(':authority', $authority);

        $stmt->execute();

        $success_message = 'アカウントの更新が完了しました。';
    } catch (Exception $e) {
        $error_message = 'エラーが発生しました: ' . $e->getMessage();
    }
} else {
    die("Invalid request");
}
?>


<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>アカウント更新完了</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        .header, .footer {
            padding: 20px;
            background-color: #f8f8f8;
            border-bottom: 1px solid #ddd;
            text-align: center;
        }
        h2 {
            text-align: left;
            margin-left: 20px;
        }
        .container {
            padding: 50px 0;
            text-align: center;
        }
        .message {
            font-size: 35px;
            color: black;
            font-weight: bold;
            margin-top: 30px;
        }
        a {
            display: inline-block;
            padding: 10px 20px;
            font-size: 16px;
            color: #fff;
            background-color: #007bff;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 20px;
        }
        a:hover {
            background-color: #0056b3;
        }
        .error {
            color: red;
            font-size: 18px;
            margin-top: 20px;
        }
        .success {
            color: green;
            font-size: 18px;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="header">
        <p>ナビゲーションバー</p>
    </div>
    <h2>アカウント更新完了</h2>
    <div class="container">
        <?php if ($error_message): ?>
            <p class="error"><?php echo htmlspecialchars($error_message, ENT_QUOTES, 'UTF-8'); ?></p>
        <?php elseif ($success_message): ?>
            <p class="message"><?php echo htmlspecialchars($success_message, ENT_QUOTES, 'UTF-8'); ?></p>
        <?php endif; ?>
        <a href="index.php">TOPページへ戻る</a>
    </div>
    <div class="footer">
        <p>フッター</p>
    </div>
</body>
</html>
