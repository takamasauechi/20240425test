<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>お絵描きページ</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
</head>

<body>
    <canvas id="myCanvas" width="600" height="600"></canvas>
    <button id="saveToDatabase">投稿する</button>

    <script>
        var canvas = document.getElementById('myCanvas');
        var ctx = canvas.getContext('2d');

        // 描画関数
        function draw(event) {
            var mousePos = getMousePos(canvas, event);

            // 線を引く
            ctx.lineTo(mousePos.x, mousePos.y);
            ctx.stroke();
        }

        // マウスの位置を取得する関数
        function getMousePos(canvas, event) {
            var rect = canvas.getBoundingClientRect();
            return {
                x: event.clientX - rect.left,
                y: event.clientY - rect.top
            };
        }

        // マウスが押されたときの処理
        canvas.addEventListener('mousedown', function(event) {
            var mousePos = getMousePos(canvas, event);

            // 描画開始点を設定
            ctx.beginPath();
            ctx.moveTo(mousePos.x, mousePos.y);

            // マウスが動いたときの処理
            canvas.addEventListener('mousemove', draw);
        });

        // マウスが離されたときの処理
        canvas.addEventListener('mouseup', function() {
            // 描画の終了
            ctx.closePath();

            // マウスが動いたときの処理を削除
            canvas.removeEventListener('mousemove', draw);
        });

        // 保存ボタンが押されたときの処理
        document.getElementById('saveToDatabase').addEventListener('click', function() {
            // Canvasから画像データを取得してDataURL形式に変換
            var imageData = canvas.toDataURL('image/png');

            // 名前とタイトルの値を取得
            var name = prompt("名前を入力してください:");
            var title = prompt("タイトルを入力してください:");

            // 画像データと名前、タイトルをAjaxリクエストで送信
            $.ajax({
                url: 'save_to_database.php',
                type: 'POST',
                data: {
                    imageData: imageData,
                    nname: name,
                    title: title
                },
                success: function(response) {
                    alert('画像を保存しました！');
                    // 成功時の処理をここに記述
                },
                error: function(xhr, status, error) {
                    alert('画像の保存に失敗しました。');
                    console.error(xhr.responseText);
                }
            });
        });
    </script>
</body>

</html>