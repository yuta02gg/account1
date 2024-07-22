<?php
include 'db.php';
session_start();

// 初期化
$error_message = '';
$success_message = '';

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
        $stmt = $conn->prepare("INSERT INTO accounts (family_name, last_name, family_name_kana, last_name_kana, mail, password, gender, postal_code, prefecture, address_1, address_2, authority) 
                                VALUES (:family_name, :last_name, :family_name_kana, :last_name_kana, :mail, :password, :gender, :postal_code, :prefecture, :address_1, :address_2, :authority)");

        $stmt->bindParam(':family_name', $family_name);
        $stmt->bindParam(':last_name', $last_name);
        $stmt->bindParam(':family_name_kana', $family_name_kana);
        $stmt->bindParam(':last_name_kana', $last_name_kana);
        $stmt->bindParam(':mail', $mail);
        $hashed_password = password_hash($password, PASSWORD_DEFAULT); // 一時変数にハッシュ化されたパスワードを格納
        $stmt->bindParam(':password', $hashed_password); // パスワードはハッシュ化
        $stmt->bindParam(':gender', $gender);
        $stmt->bindParam(':postal_code', $postal_code);
        $stmt->bindParam(':prefecture', $prefecture);
        $stmt->bindParam(':address_1', $address_1);
        $stmt->bindParam(':address_2', $address_2);
        $stmt->bindParam(':authority', $authority);

        if ($stmt->execute()) {
            // 登録成功
            $_SESSION = []; // セッションデータのクリア
            if (ini_get("session.use_cookies")) {
                $params = session_get_cookie_params();
                setcookie(session_name(), '', time() - 42000,
                    $params["path"], $params["domain"],
                    $params["secure"], $params["httponly"]
                );
            }
            session_destroy();
            $success_message = "アカウント登録が完了しました。";
        } else {
            // エラーが発生した場合
            $error_message = "エラーが発生したためアカウント登録できません。";
        }
    } catch (PDOException $e) {
        // データベースエラーが発生した場合
        error_log("Database error: " . $e->getMessage()); // エラーメッセージをログに記録
        $error_message = "エラーが発生したためアカウント登録できません。";
    } catch (Exception $e) {
        // その他のエラーが発生した場合
        error_log("General error: " . $e->getMessage()); // エラーメッセージをログに記録
        $error_message = "エラーが発生したためアカウント登録できません。";
    }
} else {
    $error_message = "エラーが発生したためアカウント登録できません。";
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>アカウント登録完了画面</title>
    <style type="text/css">
        body {
            font-family: Arial, sans-serif;
        }
        .header, .footer {
            padding: 20px;
            background-color: #f8f8f8;
            border-bottom: 1px solid #ddd;
            
        }
        p {
            text-align: center;
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
    <div class="container">  
        <h1>アカウント登録完了画面</h1>
        <div class="main">
            <?php if ($error_message): ?>
                <p class="error"><?php echo htmlspecialchars($error_message, ENT_QUOTES, 'UTF-8'); ?></p>
            <?php elseif ($success_message): ?>
                <p class="success"><?php echo htmlspecialchars($success_message, ENT_QUOTES, 'UTF-8'); ?></p>
            <?php endif; ?>
            <a href="index.php">TOPページへ戻る</a>
        </div>
    </div>
    <div class="footer">
        <p>フッター</p>
    </div>
</body>
</html>
