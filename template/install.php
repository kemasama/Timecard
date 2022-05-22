<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width,initial-scale=1" />
        <title>インストール | タイムカード</title>
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

        <div class="container mt-3">
            <?php if($args["step"] == "welcome"): ?>
            <h2>Welcome to Installer</h2>
            <p>
                インストーラーを実行するには、ボタンをクリックしてください。
            </p>
            <form class="form" method="POST">
                <button class="btn btn-success" name="step" value="welcome">インストール</button>
            </form>
            <?php elseif($args["step"] == "done"): ?>
            <h2>インストール完了</h2>
            <p>
                インストール作業が完了しました。<br />
                インストーラーを削除するには、ボタンをクリックしてください。
            </p>
            <form class="form" method="POST">
                <button class="btn btn-danger" name="step" value="done">インストーラー削除</button>
            </form>
            <?php elseif($args["step"] == "mysql"): ?>
            <h2>MYSQL設定</h2>
            <form class="form" method="POST">
                <div class="form-group row">
                    <div class="col-md-2">
                        <label for="hostname" class="form-label">ホスト名</label>
                    </div>
                    <div class="col-md-7">
                        <input class="form-control" type="text" name="hostname" id="hostname" required />
                    </div>
                    <div class="col-md-3 form-text">
                        ホスト名を入力してください。
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-md-2">
                        <label for="dbname" class="form-label">データベース名</label>
                    </div>
                    <div class="col-md-7">
                        <input class="form-control" type="text" name="dbname" id="dbname" required />
                    </div>
                    <div class="col-md-3 form-text">
                        データベース名を入力してください。
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-md-2">
                        <label for="username" class="form-label">ユーザー名</label>
                    </div>
                    <div class="col-md-7">
                        <input class="form-control" type="text" name="username" id="username" required />
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
                        <input class="form-control" type="password" name="password" id="password" required />
                    </div>
                    <div class="col-md-3 form-text">
                        パスワードを入力してください。
                    </div>
                </div>

                <input type="hidden" name="step" value="mysql" />

                <div class="form-group row">
                    <div class="col-md-2">
                    </div>
                    <div class="col-md-7">
                        <button class="btn btn-primary" type="submit">設定</button>
                    </div>
                    <div class="col-md-3 form-text">
                    </div>
                </div>
            </form>
            <?php elseif($args["step"] == "link"): ?>
            <h2>リンク設定</h2>
            <form class="form" method="POST">
                <div class="form-group row">
                    <div class="col-md-2">
                        <label for="url" class="form-label">ウェブサイトURL</label>
                    </div>
                    <div class="col-md-7">
                        <input class="form-control" type="url" name="url" id="url" required />
                    </div>
                    <div class="col-md-3 form-text">
                        ウェブサイトURLを入力してください。
                    </div>
                </div>

                <input type="hidden" name="step" value="link" />

                <div class="form-group row">
                    <div class="col-md-2">
                    </div>
                    <div class="col-md-7">
                        <button class="btn btn-primary" type="submit">設定</button>
                    </div>
                    <div class="col-md-3 form-text">
                    </div>
                </div>
            </form>
            <?php elseif($args["step"] == "account"): ?>
            <h2>管理者アカウント作成</h2>
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
                <input type="hidden" name="step" value="account" />

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
            <?php endif; ?>
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
