<?php
session_start();
require_once 'db.php';

$error_message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $mail = $_POST['mail'] ?? '';
    $password = $_POST['password'] ?? '';

    if (empty($mail) || empty($password)) {
        $error_message = 'メールアドレスとパスワードを入力してください。';
    } else {
        try {
            $dbh = getDbConnection();

            $sql = 'SELECT password, authority FROM accounts WHERE mail = :mail';
            $stmt = $dbh->prepare($sql);
            $stmt->bindParam(':mail', $mail);
            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user && password_verify($password, $user['password'])) {
                $_SESSION['authority'] = $user['authority'];
                header('Location: index.php');
                exit;
            } else {
                $error_message = 'メールアドレスまたはパスワードが正しくありません。';
            }
        } catch (PDOException $e) {
            $error_message = 'エラーが発生したためログイン情報を取得できません。';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>ログイン画面</title>
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
        .container {
            width: 450px;
            margin: 20px auto;
            text-align: center;
        }
        h2 {
            text-align: left;
            margin-left: 20px;
        }
        .form-group {
            margin-bottom: 15px;
            display: flex;
            align-items: center;
        }
        .form-group label {
            width: 140px;
            font-weight: bold;
            text-align: right;
            margin-right: 10px;
        }
        .form-group input {
            flex: 1;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        button {
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            border: none;
            cursor: pointer;
            border-radius: 4px;
            width: 100%;
            box-sizing: border-box;
        }
        button:hover {
            background-color: #0056b3;
        }
        .error {
            color: red;
            margin-bottom: 20px;
            text-align: left;
            margin-left: 20px;
        }
    </style>
</head>
<body>
    <div class="header">
        <p>ナビゲーションバー</p>
    </div>
    <h2>ログイン画面</h2>
    <div class="container">
        <?php if ($error_message): ?>
            <p class="error"><?php echo htmlspecialchars($error_message, ENT_QUOTES, 'UTF-8'); ?></p>
        <?php endif; ?>
        <form action="login.php" method="POST">
            <div class="form-group">
                <label for="mail">メールアドレス:</label>
                <input type="email" id="mail" name="mail" required>
            </div>
            <div class="form-group">
                <label for="password">パスワード:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit">ログイン</button>
        </form>
    </div>
    <div class="footer">
        <p>フッター</p>
    </div>
</body>
</html>
