<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="reset.css">
    <link rel="stylesheet" href="login.css">
    <title>ログイン</title>
</head>

<body>
    <h2>ログイン</h2>
    <form action="login_process.php" method="POST">
        <div>
            <label for="username">ユーザー名:</label>
            <input type="text" id="username" name="username" required><br>
        </div>
        <div>
            <label for="password">パスワード:</label>
            <input type="password" id="password" name="password" required><br>
        </div>
        <div>
            <input type="submit" value="ログイン">
        </div>
    </form>
</body>

</html>