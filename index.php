<?php
session_start();
$authority = isset($_SESSION['authority']) ? $_SESSION['authority'] : 0;
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="Home画面">
    <meta name="keywords" content="">
    <title>Home画面</title>
    <style type="text/css">
        .logo img {
            width: 200px;
            height: 70px;
        }

        header {
            width: 100%;
            height: 40px;
            background-color: black;
            margin: 0 auto;
            color: white;
        }

        header ul {
            display: flex;
            align-items: center;
            padding-left: 10px;
            list-style: none;
            margin: 0;
            height: 100%;
        }

        header ul li {
            margin-right: 50px;
            font-size: 18px;
        }

        header ul li a {
            color: white;
            text-decoration: none;
        }

        h1 {
            margin: 10px 0;
            border-left: 5px solid black;
            border-bottom: 2px solid black;
            padding-left: 5px;
        }

        h4 {
            font-family: serif;
            margin: 7px 0;
        }

        .book img {
            width: 100%;
            height: auto;
        }

        h3 {
            font-family: serif;
            margin: 10px 0;
        }

        .b {
            font-family: serif;
            border-bottom: 3px solid gray;
        }

        .a {
            margin-top: 25px;
        }

        .box2 {
            width: 100%;
            background-color: lightgray;
            text-align: center;
            padding: 10px 0;
        }

        .box2 img {
            width: 220px;
            margin: 10px;
        }

        .box2 .box_pic2 {
            display: inline-block;
        }

        .box_pic2 p {
            font-size: 10px;
        }

        .left {
            float: left;
            width: 69%;
            margin-bottom: 40px;
            border: 5px solid blue;
            padding: 10px;
            box-sizing: border-box;
        }

        .right {
            float: left;
            width: 30%;
            margin-bottom: 40px;
            border: 5px solid red;
            padding: 10px;
            box-sizing: border-box;
        }

        .kiji, .link, .kateg {
            list-style: none;
            margin: 20px 0;
            padding-left: 20px;
        }

        footer {
            clear: left;
            width: 100%;
            height: 60px;
            color: white;
            background-color: black;
            text-align: center;
            line-height: 60px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <div class="logo"><img src="diblog_logo.jpg" alt="D.I.Blog Logo"></div>

    <header>
        <ul>
            <li><a href="#">トップ</a></li>
            <li><a href="#">プロフィール</a></li>
            <li><a href="#">D.I.Blog について</a></li>
            <li><a href="#">登録フォーム</a></li>
            <li><a href="#">問い合わせ</a></li>
            <li><a href="#">その他</a></li>
            <?php if ($authority === 1): ?>
                <li><a href="regist.php">アカウント登録</a></li>
                <li><a href="list.php">アカウント一覧</a></li>
            <?php endif; ?>
        </ul>
    </header>

    <main>
        <div class="left">
            <h1>プログラミングに役立つ書籍</h1>
            <h4>2017年1月15日</h4>
            <div class="book"><img src="bookstore.jpg" alt="Bookstore"></div>
            <h3>D.I.BlogはD.I.Worksが提供する演習課題です。</h3>
            <h3>記事中身</h3>
            <div class="box2">
                <div class="box_pic2">
                    <img src="pic1.jpg" alt="ドメイン取得方法">
                    <p>ドメイン取得方法</p>
                </div>
                <div class="box_pic2">
                    <img src="pic2.jpg" alt="快適な職場環境">
                    <p>快適な職場環境</p>
                </div>
                <div class="box_pic2">
                    <img src="pic3.jpg" alt="Linuxの基礎">
                    <p>Linuxの基礎</p>
                </div>
                <div class="box_pic2">
                    <img src="pic4.jpg" alt="マーケティング入門">
                    <p>マーケティング入門</p>
                </div>
                <div class="box_pic2">
                    <img src="pic5.jpg" alt="アクティブラーニング">
                    <p>アクティブラーニング</p>
                </div>
                <div class="box_pic2">
                    <img src="pic6.jpg" alt="CSSの効率的な勉強方法">
                    <p>CSSの効率的な勉強方法</p>
                </div>
                <div class="box_pic2">
                    <img src="pic7.jpg" alt="リーダブルコードとは">
                    <p>リーダブルコードとは</p>
                </div>
                <div class="box_pic2">
                    <img src="pic8.jpg" alt="HTML5の可能性">
                    <p>HTML5の可能性</p>
                </div>
            </div>
        </div>

        <div class="right">
            <div class="a">
                <h3 class="b">人気の記事</h3>
                <ul class="kiji">
                    <li>PHPオススメ本</li>
                    <li>PHP MyAdminの使い方</li>
                    <li>いま人気のエディタTops</li>
                    <li>HTMLの基礎</li>
                </ul>

                <h3 class="b">オススメリンク</h3>
                <ul class="link">
                    <li>ディーアイワークス株式会社</li>
                    <li>XAMPPのダウンロード</li>
                    <li>Eclipseのダウンロード</li>
                    <li>Braketsのダウンロード</li>
                </ul>

                <h3 class="b">カテゴリー</h3>
                <ul class="kateg">
                    <li>HTML</li>
                    <li>PHP</li>
                    <li>MySQL</li>
                    <li>JavaScript</li>
                </ul>
            </div>
        </div>
    </main>

    <footer>
        Copyright D.I.works D.I.blog is the one which provides A to Z about programming
    </footer>
</body>
</html>
