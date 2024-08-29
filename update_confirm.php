<?php
session_start();
include 'db.php';

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

    // 入力値をセッションに保存
    $_SESSION['id'] = $_POST['id'];
    $_SESSION['family_name'] = $_POST['family_name'];
    $_SESSION['last_name'] = $_POST['last_name'];
    $_SESSION['family_name_kana'] = $_POST['family_name_kana'];
    $_SESSION['last_name_kana'] = $_POST['last_name_kana'];
    $_SESSION['mail'] = $_POST['mail'];
    $_SESSION['password'] = $_POST['password'];
    $_SESSION['gender'] = $_POST['gender'];
    $_SESSION['postal_code'] = $_POST['postal_code'];
    $_SESSION['prefecture'] = $_POST['prefecture'];
    $_SESSION['address_1'] = $_POST['address_1'];
    $_SESSION['address_2'] = $_POST['address_2'];
    $_SESSION['authority'] = $_POST['authority'];
} else {
    die("Invalid request");
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>アカウント更新確認画面</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 8px;
            padding: 0;
        }
        .header, .footer {
            padding: 10px;
            background-color: #f8f8f8;
            border-bottom: 1px solid #ddd;
            text-align: center;
        }
        .container {
            width: 360px;
            margin: 20px auto;
        }
        .data {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
        }
        .data label {
            font-weight: bold;
            width: 40%;
        }
        .data span {
            width: 60%;
            padding: 5px;
            background-color: #f2f2f2;
        }
        .button-group {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }
        button {
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
            width: 100%;
            box-sizing: border-box;
        }
        button:hover {
            background-color: #45a049;
        }
        .back-button {
            background-color: #f44336;
        }
        .back-button:hover {
            background-color: #d32f2f;
        }
        .form-button {
            flex: 1;
            margin-right: 10px;
        }
        .form-button:last-child {
            margin-right: 0;
        }
    </style>
</head>
<body>
    <div class="header">
        <p>ナビゲーションバー</p>
    </div>
    <h2>アカウント更新確認画面</h2>
    <div class="container">
        <div class="data">
            <label>名前（姓）</label>
            <span><?php echo htmlspecialchars($_SESSION['family_name'], ENT_QUOTES, 'UTF-8'); ?></span>
        </div>
        <div class="data">
            <label>名前（名）</label>
            <span><?php echo htmlspecialchars($_SESSION['last_name'], ENT_QUOTES, 'UTF-8'); ?></span>
        </div>
        <div class="data">
            <label>カナ（姓）</label>
            <span><?php echo htmlspecialchars($_SESSION['family_name_kana'], ENT_QUOTES, 'UTF-8'); ?></span>
        </div>
        <div class="data">
            <label>カナ（名）</label>
            <span><?php echo htmlspecialchars($_SESSION['last_name_kana'], ENT_QUOTES, 'UTF-8'); ?></span>
        </div>
        <div class="data">
            <label>メールアドレス</label>
            <span><?php echo htmlspecialchars($_SESSION['mail'], ENT_QUOTES, 'UTF-8'); ?></span>
        </div>
        <div class="data">
            <label>パスワード</label>
            <span>
                <?php 
                if (empty($_SESSION['password'])) {
                    echo "変更なし";
                } else {
                    echo str_repeat('●', strlen($_SESSION['password'])); 
                }
                ?>
            </span>
        </div>
        <div class="data">
            <label>性別</label>
            <span><?php echo $_SESSION['gender'] == '0' ? "男" : "女"; ?></span>
        </div>
        <div class="data">
            <label>郵便番号</label>
            <span><?php echo htmlspecialchars($_SESSION['postal_code'], ENT_QUOTES, 'UTF-8'); ?></span>
        </div>
        <div class="data">
            <label>住所（都道府県）</label>
            <span><?php echo htmlspecialchars($_SESSION['prefecture'], ENT_QUOTES, 'UTF-8'); ?></span>
        </div>
        <div class="data">
            <label>住所（市区町村）</label>
            <span><?php echo htmlspecialchars($_SESSION['address_1'], ENT_QUOTES, 'UTF-8'); ?></span>
        </div>
        <div class="data">
            <label>住所（番地）</label>
            <span><?php echo htmlspecialchars($_SESSION['address_2'], ENT_QUOTES, 'UTF-8'); ?></span>
        </div>
        <div class="data">
            <label>アカウント権限</label>
            <span><?php echo $_SESSION['authority'] == '0' ? "一般" : "管理者"; ?></span>
        </div>
        <div class="button-group">
            <button type="button" class="back-button form-button" onclick="history.back()">前に戻る</button>
            <form action="update_complete.php" method="POST" class="form-button">
                <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token'], ENT_QUOTES, 'UTF-8'); ?>">
                <button type="submit">更新する</button>
            </form>
        </div>
    </div>
    <div class="footer">
        <p>フッター</p>
    </div>
</body>
</html>
