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
    <h1>コメント一覧</h1>
    <button onclick="fetchComments()">コメントを取得する</button>
    <div class="otoiitiran" id="commentList">
        <!-- コメントのテーブルは最初は空 -->
        <table>
            <tr>
                <th>ID</th>
                <th>名前</th>
                <th>メールアドレス</th>
                <th>コメント</th>
            </tr>
        </table>
    </div>

    <div class="link">
        <a href="index.php"><input type="button" value="HOME"></a>
    </div>
    <a href="login.php"><input type="button" value="管理ページ"></a>
    <script>
        function fetchComments() {
            $.ajax({
                url: "fetch_comments.php", // コメントを取得するPHPファイルのパス
                type: "GET",
                success: function(data) {
                    // 取得したコメントをテーブルに表示
                    $('#commentList table').html(data);
                },
                error: function(xhr, status, error) {
                    console.error("エラー: " + error);
                }
            });
        }
    </script>
</body>

</html>