<?php
session_start();
include 'db.php';

// 権限チェック
if (!isset($_SESSION['authority']) || $_SESSION['authority'] != 1) {
    echo 'アクセスが拒否されました。';
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // データをセッションに保存するのではなく、直接POSTデータを変数に保存
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

    // パスワードをマスクする
    $masked_password = str_repeat('●', strlen($password));
} else {
    // POSTリクエストではない場合、前のページに戻る
    header("Location: regist.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>アカウント登録確認画面</title>
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
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
        }
        button:hover {
            background-color: #45a049;
        }
        .buttons {
            display: flex;
            justify-content: space-between;
        }
    </style>
</head>
<body>
     <div class="header">
        <p>ナビゲーションバー</p>
    </div>
    <h2>アカウント登録確認画面</h2>
    <div class="container">
        <div class="data">
            <label>名前（姓）</label>
            <span><?php echo htmlspecialchars($family_name, ENT_QUOTES, 'UTF-8'); ?></span>
        </div>
        <div class="data">
            <label>名前（名）</label>
            <span><?php echo htmlspecialchars($last_name, ENT_QUOTES, 'UTF-8'); ?></span>
        </div>
        <div class="data">
            <label>カナ（姓）</label>
            <span><?php echo htmlspecialchars($family_name_kana, ENT_QUOTES, 'UTF-8'); ?></span>
        </div>
        <div class="data">
            <label>カナ（名）</label>
            <span><?php echo htmlspecialchars($last_name_kana, ENT_QUOTES, 'UTF-8'); ?></span>
        </div>
        <div class="data">
            <label>メールアドレス</label>
            <span><?php echo htmlspecialchars($mail, ENT_QUOTES, 'UTF-8'); ?></span>
        </div>
        <div class="data">
            <label>パスワード</label>
            <span><?php echo htmlspecialchars($masked_password, ENT_QUOTES, 'UTF-8'); ?></span>
        </div>
        <div class="data">
            <label>性別</label>
            <span><?php echo $gender == '0' ? "男" : ($gender == '1' ? "女" : ""); ?></span>
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
            <span><?php echo $authority == '0' ? "一般" : ($authority == '1' ? "管理者" : ""); ?></span>
        </div>

        <div class="buttons">
            <form action="regist_complete.php" method="post">
                <!-- 隠しフィールドとしてPOSTデータを送信 -->
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
                <button type="submit">登録する</button>
            </form>
            <button type="button" onclick="history.back()">前に戻る</button>
        </div>
    </div>
    <div class="footer">
        <p>フッター</p>
    </div>
</body>
</html>
