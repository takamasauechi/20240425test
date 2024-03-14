<?php
// データベースに接続
try {
    $pdo = new PDO('mysql:dbname=sukinakoto;host=127.0.0.1;charset=utf8', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // エラー処理
    echo "データベースに接続できません: " . $e->getMessage();
    exit();
}

// Ajaxリクエストから画像データと名前、タイトルを受け取る
$imageData = isset($_POST['imageData']) ? $_POST['imageData'] : '';
$name = isset($_POST['nname']) ? $_POST['nname'] : '';
$title = isset($_POST['title']) ? $_POST['title'] : '';

// 画像データをディレクトリに保存
$imagePath = 'gallery/' . uniqid('image_') . '.png';
file_put_contents($imagePath, base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $imageData)));

// 画像のパスをデータベースに保存
try {
    $stmt = $pdo->prepare('INSERT INTO paintings (imagePath, nname, title) VALUES (:imagePath, :nname, :title)');
    $stmt->bindParam(':imagePath', $imagePath, PDO::PARAM_STR);
    $stmt->bindParam(':nname', $name, PDO::PARAM_STR);
    $stmt->bindParam(':title', $title, PDO::PARAM_STR);
    $stmt->execute();
    // レスポンスを返す（成功）
    $data = json_encode(["status" => "200"]);
    echo $data;
} catch (PDOException $e) {
    // エラー処理
    $error_message = "データベースへの挿入に失敗しました: " . $e->getMessage();
    $data = json_encode(["status" => "500", "error" => $error_message]);
    echo $data;
}
