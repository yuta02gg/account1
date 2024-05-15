<?php
include 'includes/db.php';
session_start();
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>アカウント登録</title>
    <style type="text/css">
        body {
            font-family: Arial, sans-serif;
        }
        form {
            width: 300px;
            margin: 0 auto;
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
        }
        button:hover {
            background-color: #45a049;
        }
        .error {
            color: red;
            margin-top: -10px;
            margin-bottom: 10px;
        }
    </style>
    <script>
        function validateForm() {
            let isValid = true;
            document.querySelectorAll('.error').forEach(e => e.remove());

            const requiredFields = [
                'family_name', 'last_name', 'family_name_kana', 'last_name_kana', 
                'mail', 'password', 'postal_code', 'prefecture', 
                'address_1', 'address_2'
            ];

            const patterns = {
                family_name: /^[ぁ-んァ-ヶ一-龠]+$/,
                last_name: /^[ぁ-んァ-ヶ一-龠]+$/,
                family_name_kana: /^[ァ-ヶー]+$/,
                last_name_kana: /^[ァ-ヶー]+$/,
                mail: /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/,
                password: /^[a-zA-Z0-9]+$/,
                postal_code: /^[0-9]{7}$/,
                address_1: /^[ぁ-んァ-ヶ一-龠0-9- ]+$/,
                address_2: /^[ぁ-んァ-ヶ一-龠0-9- ]+$/
            };

            requiredFields.forEach(field => {
                const value = document.forms['registForm'][field].value.trim();
                if (!value) {
                    const error = document.createElement('div');
                    error.className = 'error';
                    error.innerText = `${field.replace('_', ' ')} が未入力です。`;
                    document.forms['registForm'][field].parentElement.appendChild(error);
                    isValid = false;
                } else if (patterns[field] && !patterns[field].test(value)) {
                    const error = document.createElement('div');
                    error.className = 'error';
                    error.innerText = `${field.replace('_', ' ')} の形式が正しくありません。`;
                    document.forms['registForm'][field].parentElement.appendChild(error);
                    isValid = false;
                }
            });

            return isValid;
        }
    </script>
</head>
<body>
    <form name="registForm" action="regist_confirm.php" method="post" onsubmit="return validateForm()">
        <label for="family_name">名前（姓）</label>
        <input type="text" id="family_name" name="family_name" maxlength="10" required>

        <label for="last_name">名前（名）</label>
        <input type="text" id="last_name" name="last_name" maxlength="10" required>

        <label for="family_name_kana">カナ（姓）</label>
        <input type="text" id="family_name_kana" name="family_name_kana" maxlength="10" required>

        <label for="last_name_kana">カナ（名）</label>
        <input type="text" id="last_name_kana" name="last_name_kana" maxlength="10" required>

        <label for="mail">メールアドレス</label>
        <input type="email" id="mail" name="mail" maxlength="100" required>

        <label for="password">パスワード</label>
        <input type="password" id="password" name="password" maxlength="10" required>

        <label>性別</label>
        <input type="radio" name="gender" value="0" checked> 男
        <input type="radio" name="gender" value="1"> 女<br>

        <label for="postal_code">郵便番号</label>
        <input type="text" id="postal_code" name="postal_code" maxlength="7" required>

        <label for="prefecture">住所（都道府県）</label>
        <select id="prefecture" name="prefecture" required>
            <option value="">選択してください</option>
            <option value="北海道">北海道</option>
            <option value="青森県">青森県</option>
            <option value="岩手県">岩手県</option>
            <option value="宮城県">宮城県</option>
            <option value="秋田県">秋田県</option>
            <option value="山形県">山形県</option>
            <option value="福島県">福島県</option>
            <option value="茨城県">茨城県</option>
            <option value="栃木県">栃木県</option>
            <option value="群馬県">群馬県</option>
            <option value="埼玉県">埼玉県</option>
            <option value="千葉県">千葉県</option>
            <option value="東京都">東京都</option>
            <option value="神奈川県">神奈川県</option>
            <option value="新潟県">新潟県</option>
            <option value="富山県">富山県</option>
            <option value="石川県">石川県</option>
            <option value="福井県">福井県</option>
            <option value="山梨県">山梨県</option>
            <option value="長野県">長野県</option>
            <option value="岐阜県">岐阜県</option>
            <option value="静岡県">静岡県</option>
            <option value="愛知県">愛知県</option>
            <option value="三重県">三重県</option>
            <option value="滋賀県">滋賀県</option>
            <option value="京都府">京都府</option>
            <option value="大阪府">大阪府</option>
            <option value="兵庫県">兵庫県</option>
            <option value="奈良県">奈良県</option>
            <option value="和歌山県">和歌山県</option>
            <option value="鳥取県">鳥取県</option>
            <option value="島根県">島根県</option>
            <option value="岡山県">岡山県</option>
            <option value="広島県">広島県</option>
            <option value="山口県">山口県</option>
            <option value="徳島県">徳島県</option>
            <option value="香川県">香川県</option>
            <option value="愛媛県">愛媛県</option>
            <option value="高知県">高知県</option>
            <option value="福岡県">福岡県</option>
            <option value="佐賀県">佐賀県</option>
            <option value="長崎県">長崎県</option>
            <option value="熊本県">熊本県</option>
            <option value="大分県">大分県</option>
            <option value="宮崎県">宮崎県</option>
            <option value="鹿児島県">鹿児島県</option>
            <option value="沖縄県">沖縄県</option>
        </select><br>

        <label for="address_1">住所（市区町村）</label>
        <input type="text" id="address_1" name="address_1" maxlength="10" required>

        <label for="address_2">住所（番地）</label>
        <input type="text" id="address_2" name="address_2" maxlength="100" required>

        <label for="authority">アカウント権限</label>
        <select id="authority" name="authority" required>
            <option value="0">一般</option>
            <option value="1">管理者</option>
        </select><br>

        <button type="submit">確認する</button>
    </form>
</body>
</html>
