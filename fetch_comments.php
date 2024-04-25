<?php
try {
    $pdo = new PDO('mysql:dbname=sukinakoto;host=127.0.0.1', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $pdo->query('SELECT * FROM comment WHERE visible = 0');
    $stmt->execute();
    $comments = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // 取得したコメントをHTML形式で出力
    foreach ($comments as $comment) {
        echo "<tr>";
        echo "<td>{$comment['id']}</td>";
        echo "<td>{$comment['name']}</td>";
        echo "<td>{$comment['address']}</td>";
        echo "<td>{$comment['comment']}</td>";
        echo "</tr>";
    }
} catch (PDOException $e) {
    echo "エラー: " . $e->getMessage();
}
