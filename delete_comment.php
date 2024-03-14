<?php
// データベースに接続
try {
    $pdo = new PDO('mysql:dbname=sukinakoto;host=127.0.0.1', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // POSTリクエストから注文IDを取得
    if (isset($_POST['comment_id'])) {
        $comment_id = $_POST['comment_id'];

        // 注文を削除するSQL文を準備
        $stmt = $pdo->prepare("DELETE FROM comment WHERE id = ?");
        // パラメータをバインドしてSQLを実行
        $stmt->execute([$comment_id]);

        // 削除が成功したことをクライアントに通知
        echo "削除が成功しました";
    } else {
        // 注文IDが提供されていない場合はエラーメッセージを返す
        echo "IDが提供されていません";
    }
} catch (PDOException $e) {
    // エラーが発生した場合はエラーメッセージを返す
    echo "エラー: " . $e->getMessage();
}
?>