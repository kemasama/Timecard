<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width,initial-scale=1" />
        <title>ユーザー作成 | タイムカード</title>
        <link rel="canonical" href="<?php echo $args["canonical"]; ?>" />
        <link rel="stylesheet" href="<?php echo $args["canonical"]; ?>css/bootstrap.min.css" />
        <?php foreach ($args["config"]["heads"] as $key => $val): ?>
            <?php echo $val; ?>
        <?php endforeach; ?>
    </head>
    <body>
        <div class="container">
            <h2>タイムカード</h2>
        </div>

        <div class="container">
            <h3>ユーザー作成</h3>

            <p>
                作成するユーザー名、パスワードを入力後作成ボタンを押してください。
            </p>

            <form class="form" method="POST">
                <div class="form-group row">
                    <div class="col-md-2">
                        <label for="username" class="form-label">ユーザー名</label>
                    </div>
                    <div class="col-md-7">
                        <input type="text" value="" class="form-control" name="username" id="username" />
                    </div>
                    <div class="col-md-3 form-text">
                        ユーザー名を入力してください。
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-md-2">
                        <label for="password" class="form-label">パスワード</label>
                    </div>
                    <div class="col-md-7">
                        <input type="password" value="" class="form-control" name="password" id="password" />
                    </div>
                    <div class="col-md-3 form-text">
                        パスワードを入力してください。
                    </div>
                </div>

                <input type="hidden" name="mode" value="create" />

                <div class="form-group row">
                    <div class="col-md-2">
                    </div>
                    <div class="col-md-7">
                        <button class="btn btn-primary" type="submit">作成</button>
                    </div>
                    <div class="col-md-3 form-text">
                    </div>
                </div>
            </form>
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
