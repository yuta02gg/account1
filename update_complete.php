<?php
include 'db.php';
session_start();

// 初期化
$error_message = '';
$success_message = '';

// 権限チェック
if (!isset($_SESSION['authority']) || $_SESSION['authority'] != 1) {
    echo 'アクセスが拒否されました。';
    exit;
}

// CSRFトークンの検証
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        die("Invalid CSRF token");
    }

    if (isset($_SESSION['id'])) {
        $id = $_SESSION['id'];
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
            $conn = getDbConnection();

            // パスワードが未入力の場合はパスワード以外を更新
            if (empty($password)) {
                $stmt = $conn->prepare("UPDATE accounts SET family_name = ?, last_name = ?, family_name_kana = ?, last_name_kana = ?, mail = ?, gender = ?, postal_code = ?, prefecture = ?, address_1 = ?, address_2 = ?, authority = ? WHERE id = ?");
                $stmt->execute([$family_name, $last_name, $family_name_kana, $last_name_kana, $mail, $gender, $postal_code, $prefecture, $address_1, $address_2, $authority, $id]);
            } else {
                // パスワードが入力されている場合はハッシュ化して更新
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                $stmt = $conn->prepare("UPDATE accounts SET family_name = ?, last_name = ?, family_name_kana = ?, last_name_kana = ?, mail = ?, password = ?, gender = ?, postal_code = ?, prefecture = ?, address_1 = ?, address_2 = ?, authority = ? WHERE id = ?");
                $stmt->execute([$family_name, $last_name, $family_name_kana, $last_name_kana, $mail, $hashed_password, $gender, $postal_code, $prefecture, $address_1, $address_2, $authority, $id]);
            }

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
            $success_message = "更新完了しました";
        } catch (PDOException $e) {
            // データベースエラーが発生した場合
            error_log("Database error: " . $e->getMessage()); // エラーメッセージをログに記録
            $error_message = "エラーが発生したためアカウント更新できません。";
        } catch (Exception $e) {
            // その他のエラーが発生した場合
            error_log("General error: " . $e->getMessage()); // エラーメッセージをログに記録
            $error_message = "エラーが発生したためアカウント更新できません。";
        }
    } else {
        $error_message = "エラーが発生したためアカウント更新できません。";
    }
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
