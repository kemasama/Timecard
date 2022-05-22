<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width,initial-scale=1" />
        <title>パスワード変更 | タイムカード</title>
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
            <h3>パスワード変更</h3>

            <p>
                ユーザー名と現在のパスワード、新しいパスワードを入力して変更ボタンをクリックしてください。
            </p>

            <form class="form" method="POST">
                <div class="form-group row">
                    <div class="col-md-2">
                        <label for="username" class="form-label">ユーザー名</label>
                    </div>
                    <div class="col-md-7">
                        <input type="text" value="<?php echo $args["username"]; ?>" class="form-control" name="username" id="username" />
                    </div>
                    <div class="col-md-3 form-text">
                        ユーザー名を入力してください。
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-md-2">
                        <label for="password" class="form-label">現在パスワード</label>
                    </div>
                    <div class="col-md-7">
                        <input type="password" value="" class="form-control" name="password" id="password" />
                    </div>
                    <div class="col-md-3 form-text">
                        現在のパスワードを入力してください。
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-md-2">
                        <label for="newpassword" class="form-label">新しいパスワード</label>
                    </div>
                    <div class="col-md-7">
                        <input type="password" value="" class="form-control" name="newPassword" id="newpassword" />
                    </div>
                    <div class="col-md-3 form-text">
                        新しいパスワードを入力してください。
                    </div>
                </div>


                <div class="form-group row">
                    <div class="col-md-2">
                    </div>
                    <div class="col-md-7">
                        <button class="btn btn-primary" type="submit">変更</button>
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
