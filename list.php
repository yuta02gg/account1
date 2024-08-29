<?php
session_start();
require_once 'db.php';

// 権限チェック
if (!isset($_SESSION['authority']) || $_SESSION['authority'] != 1) {
    echo 'アクセスが拒否されました。';
    exit;
}

// 初期化
$family_name = $_GET['family_name'] ?? '';
$last_name = $_GET['last_name'] ?? '';
$family_name_kana = $_GET['family_name_kana'] ?? '';
$last_name_kana = $_GET['last_name_kana'] ?? '';
$mail = $_GET['mail'] ?? '';
$gender = isset($_GET['gender']) ? $_GET['gender'] : '';
$authority = isset($_GET['authority']) ? $_GET['authority'] : '';

$search_query = "WHERE 1=1"; // デフォルトの検索クエリを設定
$params = [];

$show_results = false;

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['search'])) {
    $show_results = true;

    if (!empty($family_name)) {
        $search_query .= " AND family_name LIKE :family_name";
        $params[':family_name'] = "%$family_name%";
    }

    if (!empty($last_name)) {
        $search_query .= " AND last_name LIKE :last_name";
        $params[':last_name'] = "%$last_name%";
    }

    if (!empty($family_name_kana)) {
        $search_query .= " AND family_name_kana LIKE :family_name_kana";
        $params[':family_name_kana'] = "%$family_name_kana%";
    }

    if (!empty($last_name_kana)) {
        $search_query .= " AND last_name_kana LIKE :last_name_kana";
        $params[':last_name_kana'] = "%$last_name_kana%";
    }

    if (!empty($mail)) {
        $search_query .= " AND mail LIKE :mail";
        $params[':mail'] = "%$mail%";
    }

    if ($gender !== '') {
        $search_query .= " AND gender = :gender";
        $params[':gender'] = $gender;
    }

    if ($authority !== '') {
        $search_query .= " AND authority = :authority";
        $params[':authority'] = $authority;
    }
}

$accounts = [];
if ($show_results) {
    try {
        $conn = getDbConnection();
        $stmt = $conn->prepare("SELECT * FROM accounts $search_query ORDER BY id DESC");
        $stmt->execute($params);
        $accounts = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        $error_message = "エラーが発生しました: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>アカウント一覧</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .header, .footer {
            padding: 10px;
            background-color: #333;
            color: #fff;
            text-align: center;
        }
        .container {
            padding: 20px;
            max-width: 1200px;
            margin: 0 auto;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            background-color: #fff;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 12px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .action-buttons {
            display: flex;
            gap: 10px;
        }
        .action-buttons button {
            padding: 5px 10px;
            cursor: pointer;
            border: none;
            background-color: #4CAF50;
            color: #fff;
            border-radius: 3px;
        }
        .action-buttons button:hover {
            background-color: #45a049;
        }
        .error {
            color: red;
            text-align: center;
            margin-bottom: 20px;
        }
        .search-form table {
            width: 100%;
            margin-bottom: 20px;
        }
        .search-form th, .search-form td {
            padding: 8px;
        }
        .search-form th {
            background-color: #f2f2f2;
            width: 150px;
        }
        .search-form input, .search-form select {
            width: 100%;
            padding: 6px;
            box-sizing: border-box;
        }
        .search-form .radio-group {
            display: flex;
            align-items: center;
        }
        .search-form .radio-group label {
            margin-right: 10px;
        }
        .search-button {
            text-align: right;
            padding-top: 10px;
        }
        .search-button button {
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            border: none;
            cursor: pointer;
            border-radius: 4px;
        }
        .search-button button:hover {
            background-color: #0056b3;
        }
    </style>
    <script>
        document.addEventListener('DOMContentLoaded', (event) => {
            let genderHidden = document.getElementById('gender-hidden');
            let radios = document.querySelectorAll('input[type=radio][name=gender-radio]');

            radios.forEach(radio => {
                radio.addEventListener('click', function() {
                    if (this.checked && this.previousChecked) {
                        this.checked = false;
                        genderHidden.value = '';
                    } else {
                        genderHidden.value = this.value;
                    }
                    radios.forEach(r => r.previousChecked = false);
                    this.previousChecked = this.checked;
                });
            });

            // 初期値設定
            genderHidden.value = document.querySelector('input[type=radio][name=gender-radio]:checked') ? document.querySelector('input[type=radio][name=gender-radio]:checked').value : '';
        });
    </script>
</head>
<body>
    <div class="header">
        <h1>アカウント一覧</h1>
    </div>
    <div class="container">
        <form action="list.php" method="GET" class="search-form">
            <input type="hidden" id="gender-hidden" name="gender" value="<?php echo htmlspecialchars($gender, ENT_QUOTES, 'UTF-8'); ?>">
            <table>
                <tr>
                    <th><label for="family_name">名前（姓）:</label></th>
                    <td><input type="text" id="family_name" name="family_name" value="<?php echo htmlspecialchars($family_name, ENT_QUOTES, 'UTF-8'); ?>"></td>
                    <th><label for="last_name">名前（名）:</label></th>
                    <td><input type="text" id="last_name" name="last_name" value="<?php echo htmlspecialchars($last_name, ENT_QUOTES, 'UTF-8'); ?>"></td>
                </tr>
                <tr>
                    <th><label for="family_name_kana">カナ（姓）:</label></th>
                    <td><input type="text" id="family_name_kana" name="family_name_kana" value="<?php echo htmlspecialchars($family_name_kana, ENT_QUOTES, 'UTF-8'); ?>"></td>
                    <th><label for="last_name_kana">カナ（名）:</label></th>
                    <td><input type="text" id="last_name_kana" name="last_name_kana" value="<?php echo htmlspecialchars($last_name_kana, ENT_QUOTES, 'UTF-8'); ?>"></td>
                </tr>
                <tr>
                    <th><label for="mail">メールアドレス:</label></th>
                    <td><input type="email" id="mail" name="mail" value="<?php echo htmlspecialchars($mail, ENT_QUOTES, 'UTF-8'); ?>"></td>
                    <th>性別:</th>
                    <td>
                        <div class="radio-group">
                            <label><input type="radio" name="gender-radio" value="0" <?php if ($gender === '0') echo 'checked'; ?>> 男</label>
                            <label><input type="radio" name="gender-radio" value="1" <?php if ($gender === '1') echo 'checked'; ?>> 女</label>
                        </div>
                    </td>
                </tr>
                <tr>
                    <th><label for="authority">アカウント権限:</label></th>
                    <td>
                        <select id="authority" name="authority">
                            <option value="" <?php if ($authority === '') echo 'selected'; ?>>選択なし</option>
                            <option value="0" <?php if ($authority === '0') echo 'selected'; ?>>一般</option>
                            <option value="1" <?php if ($authority === '1') echo 'selected'; ?>>管理者</option>
                        </select>
                    </td>
                    <td colspan="2" class="search-button"><button type="submit" name="search">検索</button></td>
                </tr>
            </table>
        </form>
        <?php if (isset($error_message)): ?>
            <p class="error"><?php echo htmlspecialchars($error_message, ENT_QUOTES, 'UTF-8'); ?></p>
        <?php endif; ?>
        <?php if ($show_results): ?>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>名前（姓）</th>
                        <th>名前（名）</th>
                        <th>カナ（姓）</th>
                        <th>カナ（名）</th>
                        <th>メールアドレス</th>
                        <th>性別</th>
                        <th>アカウント権限</th>
                        <th>削除フラグ</th>
                        <th>登録日時</th>
                        <th>更新日時</th>
                        <th>更新</th>
                        <th>削除</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($accounts)): ?>
                        <?php foreach ($accounts as $account): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($account['id'], ENT_QUOTES, 'UTF-8'); ?></td>
                                <td><?php echo htmlspecialchars($account['family_name'], ENT_QUOTES, 'UTF-8'); ?></td>
                                <td><?php echo htmlspecialchars($account['last_name'], ENT_QUOTES, 'UTF-8'); ?></td>
                                <td><?php echo htmlspecialchars($account['family_name_kana'], ENT_QUOTES, 'UTF-8'); ?></td>
                                <td><?php echo htmlspecialchars($account['last_name_kana'], ENT_QUOTES, 'UTF-8'); ?></td>
                                <td><?php echo htmlspecialchars($account['mail'], ENT_QUOTES, 'UTF-8'); ?></td>
                                <td><?php echo $account['gender'] == 0 ? "男" : "女"; ?></td>
                                <td><?php echo $account['authority'] == 0 ? "一般" : "管理者"; ?></td>
                                <td><?php echo $account['delete_flag'] == 0 ? "有効" : "無効"; ?></td>
                                <td><?php echo htmlspecialchars(substr($account['registered_time'], 0, 10), ENT_QUOTES, 'UTF-8'); ?></td>
                                <td><?php echo htmlspecialchars(substr($account['update_time'], 0, 10), ENT_QUOTES, 'UTF-8'); ?></td>
                                <td>
                                    <div class="action-buttons">
                                        <button onclick="location.href='update.php?id=<?php echo $account['id']; ?>'">更新</button>
                                    </div>
                                </td>
                                <td>
                                    <div class="action-buttons">
                                        <button onclick="location.href='delete.php?id=<?php echo $account['id']; ?>'">削除</button>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="13">該当するアカウントはありません。</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
    <div class="footer">
        <p>フッター</p>
    </div>
</body>
</html>
