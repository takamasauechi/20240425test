<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="reset.css">
    <link rel="stylesheet" href="come.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <title>コメント一覧</title>
</head>

<body>
    <h1>管理ページ</h1>
    <div class="otoiitiran">
        <table>
            <tr>
                <th>ID</th>
                <th>名前</th>
                <th>メールアドレス</th>
                <th>コメント</th>
                <!-- <th>削除</th> -->
            </tr>
            <?php
            try {
                $pdo = new PDO('mysql:dbname=sukinakoto;host=127.0.0.1', 'root', '');
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $stmt = $pdo->query('SELECT * FROM comment WHERE visible = 0');
                $stmt->execute();
                $comments = $stmt->fetchAll(PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                echo "エラー: " . $e->getMessage();
            }
            ?>


            <?php foreach ($comments as $comment) : ?>
                <tr>
                    <td><?php echo $comment['id']; ?></td>
                    <td><?php echo $comment['name']; ?></td>
                    <td><?php echo $comment['address']; ?></td>
                    <td><?php echo $comment['comment']; ?></td>

                </tr>
            <?php endforeach; ?>
        </table>
    </div>

    <div class="link">
        <a href="index.php"><input type="button" value="HOME"></a>
    </div>
    <a href="login.php"><input type="button" value="管理ページ"></a>
</body>

</html>