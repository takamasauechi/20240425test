<?php
try {
    $pdo = new PDO('mysql:dbname=sukinakoto;host=127.0.0.1', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $pdo->prepare('SELECT * FROM paintings ORDER BY created_at DESC');
    $stmt->execute();
    $paintings = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "エラー: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>絵のギャラリー</title>
    <style>
        .painting {
            margin-bottom: 20px;
            border: 1px solid #ccc;
            padding: 10px;
            width: 100%;
            height: auto;
        }

        .painting img {
            max-width: 100%;
            height: auto;
        }
    </style>
</head>

<body>
    <h1>絵のギャラリー</h1>
    <?php foreach ($paintings as $painting) : ?>
        <div class="painting">
            <!-- 修正：画像データはbase64エンコードされているため、直接表示 -->
            <?php
            // 画像データをbase64エンコードされた文字列として取得
            // imgタグで画像を表示
            echo '<img src="' . $imageData . '" alt="Painting">';
            ?>
            <p>名前: <?php echo $painting['nname']; ?></p>
            <p>タイトル: <?php echo $painting['title']; ?></p>
        </div>
    <?php endforeach; ?>
    <button><a href="canvas_form.php">Canvas</a></button>
    <button><a href="index.php">HOME</a></button>


</body>

</html>