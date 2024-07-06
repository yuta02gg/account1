<?php
session_start();

// db.phpをインクルードしてデータベース接続を確立
include('db.php');

// CSRFトークンの確認
if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
    die("Invalid CSRF token");
}

// POSTパラメータからアカウントIDを取得
$id = $_POST['id'];

$error_message = '';
$success_message = '';

if (isset($id)) {
    try {
        // データベース接続を確立
        $pdo = getDbConnection();

        // アカウントの削除フラグを1に更新するSQLクエリを準備
        $stmt = $pdo->prepare("UPDATE accounts SET delete_flag = 1 WHERE id = ?");
        
        // パラメータをバインド
        $stmt->execute([$id]);

        // ステートメントを閉じる
        $stmt->closeCursor();

        // セッション変数をリセット
        session_unset();

        // 削除成功
        $success_message = "削除完了しました";
    } catch (PDOException $e) {
        // データベースエラーが発生した場合
        error_log("Database error: " . $e->getMessage()); // エラーメッセージをログに記録
        $error_message = "エラーが発生したためアカウント削除できません。";
    } catch (Exception $e) {
        // その他のエラーが発生した場合
        error_log("General error: " . $e->getMessage()); // エラーメッセージをログに記録
        $error_message = "エラーが発生したためアカウント削除できません。";
    }
} else {
    $error_message = "エラーが発生したためアカウント削除できません。";
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>アカウント削除完了画面</title>
    <style type="text/css">
        body {
            font-family: Arial, sans-serif;
        }
        .header, .footer {
            padding: 5px;
            background-color: #f8f8f8;
            border-bottom: 1px solid #ddd;
        }
        .container {
            margin: 0 auto;
        }
        p {
            text-align: center;
        }
        h1 {
            color: #333;
            font-size: 35px;
            text-align: center;
        }
        .button-group {
            display: flex;
            justify-content: center;
            margin: 20px;
        }
        button {
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
            margin: 0 10px;
            font-size: 16px;
        }
        button:hover {
            background-color: #45a049;
        }
        .error {
            color: red;
            font-size: 18px;
            margin-top: 20px;
        }
        .success {
            font-size: 35px;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="header">
        <p>ナビゲーションバー</p>
    </div>
    <div class="container">
        <h2>アカウント削除完了画面</h2>
        <?php if ($error_message): ?>
            <h1 class="error"><?php echo htmlspecialchars($error_message, ENT_QUOTES, 'UTF-8'); ?></h1>
        <?php elseif ($success_message): ?>
            <h1 class="success"><?php echo htmlspecialchars($success_message, ENT_QUOTES, 'UTF-8'); ?></h1>
        <?php endif; ?>
        <div class="button-group">
            <button onclick="location.href='index.html'">TOPページへ戻る</button>
        </div>
    </div>
    <div class="footer">
      <p>フッター</p>
    </div> 
</body>
</html>
