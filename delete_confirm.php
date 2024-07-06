<?php
session_start();

// db.phpをインクルードしてデータベース接続を確立
include('db.php');

// CSRFトークンの確認
if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
    die("Invalid CSRF token");
}

// POSTパラメータからアカウントIDを取得
$id = $_POST['id'] ?? null;

if ($id === null) {
    die("ID is not set");
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>アカウント削除確認画面</title>
    <style type="text/css">
        body {
            font-family: Arial, sans-serif;
        }
        p{
            text-align: center;
        }
        .header, .footer {
            padding: 5px;
            background-color: #f8f8f8;
            border-bottom: 1px solid #ddd;
        }
        .container {
            width: 300px;
            margin: 20px auto;
            text-align: center;
        }
        h1 {
            color: #333;
            font-size: 20px;
        }
        .button-group {
            display: flex;
            justify-content: center;
            margin: 20px;
        }
        button {
            padding: 10px 20px;
            background-color: #ff4b5c;
            color: white;
            border: none;
            cursor: pointer;
            margin: 0 10px;
            font-size: 16px;
        }
        .back-button {
            background-color: #4CAF50;
            color: white;
        }
        .back-button:hover {
            background-color: #45a049;
        }
        .delete-button:hover {
            background-color: #ff2b3c;
        }
    </style>
</head>
<body>
    <div class="header">
        <p>ナビゲーションバー</p>
    </div>
    <h2>アカウント削除確認画面</h2>
    <div class="container">
        <h1>本当に削除してよろしいですか？</h1>
        <div class="button-group">
            <form action="delete.php" method="GET">
                <input type="hidden" name="id" value="<?php echo htmlspecialchars($id, ENT_QUOTES, 'UTF-8'); ?>">
                <button type="submit" class="back-button">前に戻る</button>
            </form>
            <form action="delete_complete.php" method="POST">
                <input type="hidden" name="id" value="<?php echo htmlspecialchars($id, ENT_QUOTES, 'UTF-8'); ?>">
                <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token'], ENT_QUOTES, 'UTF-8'); ?>">
                <button type="submit" class="delete-button">削除する</button>
            </form>
        </div>
    </div>
    <div class="footer">
        <p>フッター</p>
    </div> 
</body>
</html>
