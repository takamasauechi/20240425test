<?php
// セッションの開始
session_start();

// セッションに管理者フラグがない場合はログインページにリダイレクト
if (!isset($_SESSION['maasa'])) {
    header('Location: login.php');
    exit;
}

// データベースに接続
try {
    $pdo = new PDO('mysql:dbname=sukinakoto;host=127.0.0.1', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // POSTリクエストからコメントIDを取得し、整数にキャストする
    $commentId = isset($_POST['comment_id']) ? (int)$_POST['comment_id'] : null;

    if ($commentId === null) {
        throw new Exception('コメントIDが指定されていません。');
    }

    // コメントの表示／非表示を切り替えるためのSQLクエリを準備
    $stmt = $pdo->prepare('UPDATE comment SET visible = NOT visible WHERE id = ?');
    $stmt->execute([$commentId]);

    // 成功したことをクライアントに通知する
    http_response_code(200);
    echo "コメントの表示／非表示を切り替えました";
} catch (PDOException $e) {
    // エラーが発生した場合はエラーメッセージを表示し、500 Internal Server Errorを返す
    http_response_code(500);
    echo "エラー: " . $e->getMessage();
} catch (Exception $e) {
    // エラーが発生した場合はエラーメッセージを表示し、400 Bad Requestを返す
    http_response_code(400);
    echo "エラー: " . $e->getMessage();
}
