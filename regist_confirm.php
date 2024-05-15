<?php
include 'includes/db.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
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

    header("Location: regist_confirm.php");
    exit();
}

// セッション変数のチェックと取得
$family_name = isset($_SESSION['family_name']) ? $_SESSION['family_name'] : '';
$last_name = isset($_SESSION['last_name']) ? $_SESSION['last_name'] : '';
$family_name_kana = isset($_SESSION['family_name_kana']) ? $_SESSION['family_name_kana'] : '';
$last_name_kana = isset($_SESSION['last_name_kana']) ? $_SESSION['last_name_kana'] : '';
$mail = isset($_SESSION['mail']) ? $_SESSION['mail'] : '';
$password = isset($_SESSION['password']) ? $_SESSION['password'] : '';
$gender = isset($_SESSION['gender']) ? $_SESSION['gender'] : '';
$postal_code = isset($_SESSION['postal_code']) ? $_SESSION['postal_code'] : '';
$prefecture = isset($_SESSION['prefecture']) ? $_SESSION['prefecture'] : '';
$address_1 = isset($_SESSION['address_1']) ? $_SESSION['address_1'] : '';
$address_2 = isset($_SESSION['address_2']) ? $_SESSION['address_2'] : '';
$authority = isset($_SESSION['authority']) ? $_SESSION['authority'] : '';

?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>アカウント登録確認</title>
    <style type="text/css">
        body {
            font-family: Arial, sans-serif;
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
    <div class="container">
        <div class="data">
            <label>名前（姓）</label>
            <span><?php echo htmlspecialchars($family_name); ?></span>
        </div>
        <div class="data">
            <label>名前（名）</label>
            <span><?php echo htmlspecialchars($last_name); ?></span>
        </div>
        <div class="data">
            <label>カナ（姓）</label>
            <span><?php echo htmlspecialchars($family_name_kana); ?></span>
        </div>
        <div class="data">
            <label>カナ（名）</label>
            <span><?php echo htmlspecialchars($last_name_kana); ?></span>
        </div>
        <div class="data">
            <label>メールアドレス</label>
            <span><?php echo htmlspecialchars($mail); ?></span>
        </div>
        <div class="data">
            <label>パスワード</label>
            <span>********</span>
        </div>
        <div class="data">
            <label>性別</label>
            <span><?php echo $gender == 0 ? "男" : "女"; ?></span>
        </div>
        <div class="data">
            <label>郵便番号</label>
            <span><?php echo htmlspecialchars($postal_code); ?></span>
        </div>
        <div class="data">
            <label>住所（都道府県）</label>
            <span><?php echo htmlspecialchars($prefecture); ?></span>
        </div>
        <div class="data">
            <label>住所（市区町村）</label>
            <span><?php echo htmlspecialchars($address_1); ?></span>
        </div>
        <div class="data">
            <label>住所（番地）</label>
            <span><?php echo htmlspecialchars($address_2); ?></span>
        </div>
        <div class="data">
            <label>アカウント権限</label>
            <span><?php echo $authority == 0 ? "一般" : "管理者"; ?></span>
        </div>

        <div class="buttons">
            <form action="regist_complete.php" method="post">
                <button type="submit">登録する</button>
            </form>
            <a href="javascript:history.back()">
                <button type="button">前に戻る</button>
            </a>
        </div>
    </div>
</body>
</html>
