<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width,initial-scale=1" />
        <title>エラー | タイムカード</title>
        <link rel="canonical" href="<?php echo $args["config"]["canonical"]; ?>" />
        <link rel="stylesheet" href="<?php echo $args["config"]["canonical"]; ?>css/bootstrap.min.css" />
        <?php foreach ($args["config"]["heads"] as $key => $val): ?>
            <?php echo $val; ?>
        <?php endforeach; ?>
    </head>
    <body>
        <div class="container">
            <h2>タイムカード</h2>
            <p>
                <a href="?logout=1">ログアウト</a>
            </p>
        </div>

        <div class="container">
            <h3>エラー</h3>
            <p>
                サービスの処理中にエラーが発生しました。<br />
                ホームに戻るには<a href="<?php echo $args["config"]["canonical"]; ?>">こちら</a>をクリックしてください。<br />
            </p>
            <code>
                <?php echo $args["message"]; ?>
            </code>
            <p>
                エラーが続けて発生する場合は、サーバー管理者にお問い合わせください。
            </p>
        </div>

        <div class="container">
            <footer class="footer">
                <div class="container text-center">
                    <p class="text-muted">
                        Copyright &copy; 2022 <a href="https://devras.net">DevRas</a> All Rights Reserved.
                    </p>
                    <p class="text-muted">
                        TimeCard v1.0.0
                        <a href="https://github.com/kemasama/Timecard">github</a>
                    </p>
                </div>
            </footer>
        </div>
    </body>
</html>
