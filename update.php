<?php
session_start();
include 'db.php';

$id = $_GET['id'];
$pdo = getDbConnection();
$stmt = $pdo->prepare("SELECT * FROM accounts WHERE id = ?");
$stmt->execute([$id]);
$account = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$account) {
    die("アカウントが見つかりません。");
}

// CSRFトークンの生成
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>アカウント更新</title>
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
            width: 300px;
            margin: 20px auto;
        }
        label {
            display: block;
            margin-bottom: 5px;
        }
        input[type="text"], input[type="email"], input[type="password"], select {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            box-sizing: border-box;
        }
        input[type="radio"] {
            margin-right: 10px;
        }
        button {
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
            width: 100%;
        }
        button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div class="header">
        <p>ナビゲーションバー</p>
    </div>
    <h2>アカウント更新</h2>
    <div class="container">
        <form action="update_confirm.php" method="POST">
            <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token'], ENT_QUOTES, 'UTF-8'); ?>">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($account['id'], ENT_QUOTES, 'UTF-8'); ?>">
            <label for="family_name">名前（姓）</label>
            <input type="text" id="family_name" name="family_name" maxlength="10" value="<?php echo htmlspecialchars($account['family_name'], ENT_QUOTES, 'UTF-8'); ?>" required>
            <label for="last_name">名前（名）</label>
            <input type="text" id="last_name" name="last_name" maxlength="10" value="<?php echo htmlspecialchars($account['last_name'], ENT_QUOTES, 'UTF-8'); ?>" required>
            <label for="family_name_kana">カナ（姓）</label>
            <input type="text" id="family_name_kana" name="family_name_kana" maxlength="10" value="<?php echo htmlspecialchars($account['family_name_kana'], ENT_QUOTES, 'UTF-8'); ?>" required>
            <label for="last_name_kana">カナ（名）</label>
            <input type="text" id="last_name_kana" name="last_name_kana" maxlength="10" value="<?php echo htmlspecialchars($account['last_name_kana'], ENT_QUOTES, 'UTF-8'); ?>" required>
            <label for="mail">メールアドレス</label>
            <input type="email" id="mail" name="mail" maxlength="100" value="<?php echo htmlspecialchars($account['mail'], ENT_QUOTES, 'UTF-8'); ?>" required>
            <label for="password">パスワード</label>
            <input type="password" id="password" name="password" maxlength="10" value="<?php echo str_repeat('●', 10); ?>" required>
            <label>性別</label>
            <input type="radio" name="gender" value="0" <?php echo ($account['gender'] == 0) ? 'checked' : ''; ?>> 男
            <input type="radio" name="gender" value="1" <?php echo ($account['gender'] == 1) ? 'checked' : ''; ?>> 女<br>
            <label for="postal_code">郵便番号</label>
            <input type="text" id="postal_code" name="postal_code" maxlength="7" value="<?php echo htmlspecialchars($account['postal_code'], ENT_QUOTES, 'UTF-8'); ?>" required>
            <label for="prefecture">住所（都道府県）</label>
            <select id="prefecture" name="prefecture" required>
                <option value="">選択してください</option>
                <?php
                $prefectures = ["北海道", "青森県", "岩手県", "宮城県", "秋田県", "山形県", "福島県", "茨城県", "栃木県", "群馬県", "埼玉県", "千葉県", "東京都", "神奈川県", "新潟県", "富山県", "石川県", "福井県", "山梨県", "長野県", "岐阜県", "静岡県", "愛知県", "三重県", "滋賀県", "京都府", "大阪府", "兵庫県", "奈良県", "和歌山県", "鳥取県", "島根県", "岡山県", "広島県", "山口県", "徳島県", "香川県", "愛媛県", "高知県", "福岡県", "佐賀県", "長崎県", "熊本県", "大分県", "宮崎県", "鹿児島県", "沖縄県"];
                foreach ($prefectures as $prefecture) {
                    $selected = ($account['prefecture'] == $prefecture) ? 'selected' : '';
                    echo "<option value=\"$prefecture\" $selected>$prefecture</option>";
                }
                ?>
            </select><br>
            <label for="address_1">住所（市区町村）</label>
            <input type="text" id="address_1" name="address_1" maxlength="10" value="<?php echo htmlspecialchars($account['address_1'], ENT_QUOTES, 'UTF-8'); ?>" required>
            <label for="address_2">住所（番地）</label>
            <input type="text" id="address_2" name="address_2" maxlength="100" value="<?php echo htmlspecialchars($account['address_2'], ENT_QUOTES, 'UTF-8'); ?>" required>
            <label for="authority">アカウント権限</label>
            <select id="authority" name="authority" required>
                <option value="0" <?php echo ($account['authority'] == 0) ? 'selected' : ''; ?>>一般</option>
                <option value="1" <?php echo ($account['authority'] == 1) ? 'selected' : ''; ?>>管理者</option>
            </select>
            <button type="submit">確認する</button>
        </form>
    </div>
    <div class="footer">
        <p>フッター</p>
    </div>
</body>
</html>
