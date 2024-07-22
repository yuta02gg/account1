<?php
session_start();
$error_message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $mail = $_POST['mail'];
    $password = $_POST['password'];

    // データベース接続
    include 'db.php';

    try {
        $conn = getDbConnection();
        // SQLクエリの実行
        $sql = "SELECT * FROM accounts WHERE mail = :mail";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':mail', $mail);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            // ユーザーが見つかった場合
            if (password_verify($password, $user['password'])) {
                // パスワードが正しい場合
                $_SESSION['loggedin'] = true;
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['role'] = $user['role'];
                header("Location: index.php");
                exit();
            } else {
                // パスワードが間違っている場合
                $error_message = "メールアドレスまたはパスワードが間違っています。";
            }
        } else {
            // ユーザーが見つからない場合
            $error_message = "メールアドレスまたはパスワードが間違っています。";
        }
    } catch (Exception $e) {
        $error_message = "エラーが発生したためログイン情報を取得できません。" . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ログイン</title>
</head>
<body>
    <h2>ログイン</h2>
    <?php
    if (!empty($error_message)) {
        echo '<p style="color: red;">' . $error_message . '</p>';
    }
    ?>
    <form action="login.php" method="post">
        <label for="mail">メールアドレス:</label>
        <input type="mail" id="mail" name="mail" required><br>
        <label for="password">パスワード:</label>
        <input type="password" id="password" name="password" required><br>
        <button type="submit">ログイン</button>
    </form>
</body>
</html>
