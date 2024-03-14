<?php
session_start();

// セッションを破棄してログアウト
session_destroy();

header('Location: login.php'); // ログインページにリダイレクト
exit;
