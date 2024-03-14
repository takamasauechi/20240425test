<?php
session_start();

// ログイン認証を行う
$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';

// ここでユーザー名とパスワードの検証を行う
$valid_username = 'uechi'; // 仮のユーザー名
$valid_password = '0831'; // 仮のパスワード

$hashed_password = password_hash($password, PASSWORD_DEFAULT);

if ($username === $valid_username && password_verify($password, $hashed_password)) {
    // ログイン成功
    $_SESSION['maasa'] = true; // 管理者としてマーク
    header('Location: comment_list.php'); // コメント一覧ページにリダイレクト
    exit;
} else {
    // ログイン失敗
    $_SESSION['message'] = 'ユーザー名またはパスワードが間違っています。';
    header('Location: login.php'); // ログインページにリダイレクト
    exit;
}
