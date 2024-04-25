<?php
// エラーハンドリングを追加
try {
    // データベースに接続
    $pdo = new PDO('mysql:dbname=sukinakoto;host=127.0.0.1', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


    $stmt = $pdo->query('SELECT * FROM comment');
    $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "エラー: " . $e->getMessage(); // エラーメッセージを表示
}
?>



<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="reset.css">
    <link rel="stylesheet" href="style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <title>1</title>
</head>

<body>

    <canvas id="myCanvas1"></canvas>

    <header class="title">
        <h1>cinema</h1>
    </header>


    <a class="ganre__1" href="page1.html"></a>
    <a class="ganre__2" href="page2.html"></a>
    <a class="ganre__3" href="page3.html"></a>
    <a class="ganre__4" href="page4.html"></a>
    <a class="ganre__5" href="page5.html"></a>


    <footer>
        <div class="flexbox">
            <div class="search">
                <h1>search for movies</h1>
                <h3>Click on search icon, <br>then type your keyword.</h3>
                <div>
                    <input type="text" placeholder="いち、にー、さん . . ." required>
                </div>
            </div>
        </div>
        <div class="otoi">
            <form action="index.php" method="POST">
                名前<br />
                <input type="text" id="name" name="name" size="30" value="" /><br />
                メールアドレス<br />
                <input type="text" id="address" name="address" size="30" value="" /><br />
                コメント<br />
                <textarea name="comment" id="comment" cols="32" rows="5"></textarea><br />
                <br />
                <div>
                    <input type="submit" name="submitButton" value="コメントする" />
                </div>
            </form>
            <div>
                <a href="come.php"><input type="button" value="コメント一覧へ"></a>
            </div>
        </div>

        <?php
        if (isset($_POST['submitButton'])) {

            $name = $_POST['name'];
            $address = $_POST['address'];
            $comment = $_POST['comment'];

            if ($name !== "" || $address !== "" || $comment !== "") {
                $stmt = $pdo->prepare("INSERT INTO comment (`name`, `address`, `comment`,`visible`) VALUES (?, ?, ?, ?)");
                $stmt->execute([$name, $address, $comment, 1]);
            }
        }
        ?>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                document.querySelector('form').addEventListener('submit', function(event) {

                    var nameValue = document.getElementById('name').value.trim();
                    var addressValue = document.getElementById('address').value.trim();
                    var commentValue = document.getElementById('comment').value.trim();

                    if (nameValue === '' || addressValue === '' || commentValue === '') {
                        // 空の場合は送信をキャンセルし、アラートを表示
                        event.preventDefault();
                        showAlert('名前と住所とコメントを入力してください。');
                    } else {
                        // コメント送信の確認メッセージを表示
                        var confirmMessage = "本当にコメントを送信してもよろしいですか？";
                        if (!confirm(confirmMessage)) {
                            event.preventDefault(); // 送信をキャンセル
                        }
                    }
                });
            });

            // 注文完了のメッセージをアラートとして表示する関数
            function showAlert(message) {
                alert(message);
            }
        </script>
        <script src="sukinakoto.js"></script>
    </footer>


</body>

</html>