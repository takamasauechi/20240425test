<?php
session_start();

// セッションに管理者フラグがない場合はログインページにリダイレクト
if (!isset($_SESSION['maasa'])) {
    header('Location: login.php');
    exit;
}

// データベースからコメントを取得する処理
try {
    $pdo = new PDO('mysql:dbname=sukinakoto;host=127.0.0.1', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // visible フィールドが 0 でも取得するように変更
    $stmt = $pdo->prepare('SELECT * FROM comment');
    $stmt->execute();
    $comments = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "エラー: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="reset.css">
    <link rel="stylesheet" href="kanri.css">
    <title>管理ページ</title>
</head>

<body>
    <h2>コメント管理</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>名前</th>
                <th>メールアドレス</th>
                <th>コメント</th>
                <th>表示／非表示</th>
                <th>削除</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($comments as $comment) : ?>
                <tr>
                    <td><?php echo $comment['id']; ?></td>
                    <td><?php echo $comment['name']; ?></td>
                    <td><?php echo $comment['address']; ?></td>
                    <td><?php echo $comment['comment']; ?></td>
                    <td>
                        <button onclick="toggleVisibility(<?php echo $comment['id']; ?>, <?php echo $comment['visible']; ?>)">
                            <?php echo $comment['visible'] ? '非表示' : '表示'; ?>
                        </button>
                    </td>
                    <td><button onclick="deleteComment(<?php echo $comment['id']; ?>)">削除</button></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <script>
        // PHPから渡されたコメントデータを保持するJavaScriptの配列
        var comments = <?php echo json_encode($comments); ?>;

        // 表示／非表示を切り替える関数
        function toggleVisibility(commentId, currentVisibility) {

            // comments配列から該当するコメントを探す
            var comment = comments.find(function(item) {
                return item.id === commentId;
            });

            if (comment) {
                var newVisibility = currentVisibility ? 0 : 1; // 現在の表示状態の反対の値を計算
                if (confirm("このコメントを" + (newVisibility ? "非表示" : "表示") + "にしますか？")) {
                    var xhr = new XMLHttpRequest();


                    xhr.open("POST", "toggle_visibility.php", true);
                    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                    xhr.onreadystatechange = function() {
                        if (xhr.readyState === 4 && xhr.status === 200) {
                            // 成功時にページをリロード
                            window.location.reload();
                        }
                    };
                    xhr.send("comment_id=" + commentId + "&visibility=" + newVisibility);
                }
            } else {
                console.error("コメントが見つかりませんでした。");
            }
        }

        function deleteComment(commentId) {
            if (confirm("このコメントを削除しますか？")) {
                var xhr = new XMLHttpRequest();


                xhr.open("POST", "delete_comment.php", true);
                xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                xhr.onreadystatechange = function() {
                    if (xhr.readyState === 4 && xhr.status === 200) {
                        window.location.reload();
                    }
                };
                xhr.send("comment_id=" + commentId);
            }
        }
    </script>
</body>

</html>