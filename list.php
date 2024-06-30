<?php
include 'db.php';
session_start();

try {
    $conn = getDbConnection();
    $stmt = $conn->query("SELECT * FROM accounts ORDER BY id DESC");
    $accounts = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $error_message = "エラーが発生しました: " . $e->getMessage();
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
    </style>
</head>
<body>
    <div class="header">
        <h1>アカウント一覧</h1>
    </div>
    <div class="container">
        <?php if (isset($error_message)): ?>
            <p class="error"><?php echo htmlspecialchars($error_message, ENT_QUOTES, 'UTF-8'); ?></p>
        <?php endif; ?>
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
            </tbody>
        </table>
    </div>
    <div class="footer">
        <p>フッター</p>
    </div>
</body>
</html>
