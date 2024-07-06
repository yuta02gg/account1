<?php
session_start();

// db.phpをインクルードしてデータベース接続を確立
include('db.php');

// CSRFトークンを生成
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// URLパラメータからアカウントIDを取得
$id = $_GET['id'];

// アカウントIDが指定されているか確認
if (isset($id)) {
    try {
        // データベース接続を確立
        $pdo = getDbConnection();

        // アカウント情報を取得するSQLクエリを準備
        $stmt = $pdo->prepare("SELECT * FROM accounts WHERE id = ?");
        
        // パラメータをバインド
        $stmt->execute([$id]);

        // 結果を取得
        $account = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$account) {
            throw new Exception("No account found with ID $id");
        }
    } catch (Exception $e) {
        die("Error: " . $e->getMessage());
    }
} else {
    die("ID is not set");
}

// パスワードを●でマスクする
$masked_password = str_repeat('●', 10); // 固定長のマスク表示にしています
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>アカウント削除画面</title>
    <style type="text/css">
        body {
            font-family: Arial, sans-serif;
        }
        .header, .footer {
            padding: 5px;
            background-color: #f8f8f8;
            border-bottom: 1px solid #ddd;
        }
        p {
            text-align: center;
        }
        .container {
            width: 300px;
            margin: 0 auto;
        }
        .data {
            margin-bottom: 10px;
        }
        .data label {
            display: block;
            font-weight: bold;
        }
        .data span {
            display: block;
            padding: 5px;
            background-color: #f2f2f2;
            margin-top: 5px;
        }
        button {
            padding: 10px 20px;
            background-color: #ff4b5c;
            color: white;
            border: none;
            cursor: pointer;
        }
        button:hover {
            background-color: #ff2b3c;
        }
        .buttons {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="header">
        <p>ナビゲーションバー</p>
    </div>
    <h2>アカウント削除画面</h2>
    <div class="container">
        <form action="delete_confirm.php" method="POST">
            <div class="data">
                <label>名前（姓）</label>
                <span><?php echo htmlspecialchars($account['family_name'] ?? '', ENT_QUOTES, 'UTF-8'); ?></span>
            </div>
            <div class="data">
                <label>名前（名）</label>
                <span><?php echo htmlspecialchars($account['last_name'] ?? '', ENT_QUOTES, 'UTF-8'); ?></span>
            </div>
            <div class="data">
                <label>カナ（姓）</label>
                <span><?php echo htmlspecialchars($account['family_name_kana'] ?? '', ENT_QUOTES, 'UTF-8'); ?></span>
            </div>
            <div class="data">
                <label>カナ（名）</label>
                <span><?php echo htmlspecialchars($account['last_name_kana'] ?? '', ENT_QUOTES, 'UTF-8'); ?></span>
            </div>
            <div class="data">
                <label>メールアドレス</label>
                <span><?php echo htmlspecialchars($account['mail'] ?? '', ENT_QUOTES, 'UTF-8'); ?></span>
            </div>
            <div class="data">
                <label>パスワード</label>
                <span><?php echo htmlspecialchars($masked_password, ENT_QUOTES, 'UTF-8'); ?></span>
            </div>
            <div class="data">
                <label>性別</label>
                <span><?php echo ($account['gender'] ?? 0) == 0 ? '男' : '女'; ?></span>
            </div>
            <div class="data">
                <label>郵便番号</label>
                <span><?php echo htmlspecialchars($account['postal_code'] ?? '', ENT_QUOTES, 'UTF-8'); ?></span>
            </div>
            <div class="data">
                <label>住所（都道府県）</label>
                <span><?php echo htmlspecialchars($account['prefecture'] ?? '', ENT_QUOTES, 'UTF-8'); ?></span>
            </div>
            <div class="data">
                <label>住所（市区町村）</label>
                <span><?php echo htmlspecialchars($account['address_1'] ?? '', ENT_QUOTES, 'UTF-8'); ?></span>
            </div>
            <div class="data">
                <label>住所（番地）</label>
                <span><?php echo htmlspecialchars($account['address_2'] ?? '', ENT_QUOTES, 'UTF-8'); ?></span>
            </div>
            <div class="data">
                <label>アカウント権限</label>
                <span><?php echo ($account['authority'] ?? 0) == 0 ? '一般' : '管理者'; ?></span>
            </div>
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($account['id'], ENT_QUOTES, 'UTF-8'); ?>">
            <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
            <div class="buttons">
                <button type="submit">確認する</button>
            </div>
        </form>
    </div>
    <div class="footer">
        <p>フッター</p>
    </div>
</body>
</html>
