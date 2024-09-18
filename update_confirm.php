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

    // POSTデータを取得
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
        }
        .button-group {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }
        .form-button {
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            border: none;
            cursor: pointer;
            border-radius: 4px;
        }
        .form-button:hover {
            background-color: #0056b3;
        }
        .back-button {
            background-color: #f0f0f0;
            color: #000;
        }
        .back-button:hover {
            background-color: #d0d0d0;
        }
    </style>
</head>
<body>
    <div class="header">
        <p>アカウント更新確認画面</p>
    </div>
    <div class="container">
        <div class="data">
            <label>姓</label>
            <span><?php echo htmlspecialchars($family_name, ENT_QUOTES, 'UTF-8'); ?></span>
        </div>
        <div class="data">
            <label>名</label>
            <span><?php echo htmlspecialchars($last_name, ENT_QUOTES, 'UTF-8'); ?></span>
        </div>
        <div class="data">
            <label>姓（カナ）</label>
            <span><?php echo htmlspecialchars($family_name_kana, ENT_QUOTES, 'UTF-8'); ?></span>
        </div>
        <div class="data">
            <label>名（カナ）</label>
            <span><?php echo htmlspecialchars($last_name_kana, ENT_QUOTES, 'UTF-8'); ?></span>
        </div>
        <div class="data">
            <label>メールアドレス</label>
            <span><?php echo htmlspecialchars($mail, ENT_QUOTES, 'UTF-8'); ?></span>
        </div>
        <div class="data">
            <label>パスワード</label>
            <span><?php echo empty($password) ? "変更なし" : str_repeat('●', strlen($password)); ?></span>
        </div>
        <div class="data">
            <label>性別</label>
            <span><?php echo $gender == '0' ? "男" : "女"; ?></span>
        </div>
        <div class="data">
            <label>郵便番号</label>
            <span><?php echo htmlspecialchars($postal_code, ENT_QUOTES, 'UTF-8'); ?></span>
        </div>
        <div class="data">
            <label>住所（都道府県）</label>
            <span><?php echo htmlspecialchars($prefecture, ENT_QUOTES, 'UTF-8'); ?></span>
        </div>
        <div class="data">
            <label>住所（市区町村）</label>
            <span><?php echo htmlspecialchars($address_1, ENT_QUOTES, 'UTF-8'); ?></span>
        </div>
        <div class="data">
            <label>住所（番地）</label>
            <span><?php echo htmlspecialchars($address_2, ENT_QUOTES, 'UTF-8'); ?></span>
        </div>
        <div class="data">
            <label>アカウント権限</label>
            <span><?php echo $authority == '0' ? "一般" : "管理者"; ?></span>
        </div>
        <div class="button-group">
            <button type="button" class="back-button form-button" onclick="history.back()">前に戻る</button>
            <form action="update_complete.php" method="POST" class="form-button">
                <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token'], ENT_QUOTES, 'UTF-8'); ?>">
                <input type="hidden" name="id" value="<?php echo htmlspecialchars($id, ENT_QUOTES, 'UTF-8'); ?>">
                <input type="hidden" name="family_name" value="<?php echo htmlspecialchars($family_name, ENT_QUOTES, 'UTF-8'); ?>">
                <input type="hidden" name="last_name" value="<?php echo htmlspecialchars($last_name, ENT_QUOTES, 'UTF-8'); ?>">
                <input type="hidden" name="family_name_kana" value="<?php echo htmlspecialchars($family_name_kana, ENT_QUOTES, 'UTF-8'); ?>">
                <input type="hidden" name="last_name_kana" value="<?php echo htmlspecialchars($last_name_kana, ENT_QUOTES, 'UTF-8'); ?>">
                <input type="hidden" name="mail" value="<?php echo htmlspecialchars($mail, ENT_QUOTES, 'UTF-8'); ?>">
                <input type="hidden" name="password" value="<?php echo htmlspecialchars($password, ENT_QUOTES, 'UTF-8'); ?>">
                <input type="hidden" name="gender" value="<?php echo htmlspecialchars($gender, ENT_QUOTES, 'UTF-8'); ?>">
                <input type="hidden" name="postal_code" value="<?php echo htmlspecialchars($postal_code, ENT_QUOTES, 'UTF-8'); ?>">
                <input type="hidden" name="prefecture" value="<?php echo htmlspecialchars($prefecture, ENT_QUOTES, 'UTF-8'); ?>">
                <input type="hidden" name="address_1" value="<?php echo htmlspecialchars($address_1, ENT_QUOTES, 'UTF-8'); ?>">
                <input type="hidden" name="address_2" value="<?php echo htmlspecialchars($address_2, ENT_QUOTES, 'UTF-8'); ?>">
                <input type="hidden" name="authority" value="<?php echo htmlspecialchars($authority, ENT_QUOTES, 'UTF-8'); ?>">
                <button type="submit" class="form-button">更新する</button>
            </form>
        </div>
    </div>
    <div class="footer">
        <p>フッター</p>
    </div>
</body>
</html>
