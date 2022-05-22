<!-- Version <?php echo $args["config"]["version"]; ?> -->
<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width,initial-scale=1" />
        <title>タイムカード</title>
        <link rel="canonical" href="<?php echo $args["canonical"]; ?>" />
        <link rel="stylesheet" href="<?php echo $args["canonical"]; ?>css/bootstrap.min.css" />
        <?php foreach ($args["config"]["heads"] as $key => $val): ?>
            <?php echo $val; ?>
        <?php endforeach; ?>
    </head>
    <body>
        <div class="container">
            <h2>タイムカード</h2>
            <p>
                <a href="?logout=1">ログアウト</a>
                <?php if($args["isAdmin"]): ?>
                <a href="?p=create">ユーザー作成</a>
                <?php endif; ?>
                <a href="?p=passwd">パスワード変更</a>
            </p>
            <p class="text-info">
                ようこそ、
                <?php echo $args["user"]["username"]; ?>
                さん！
            </p>
        </div>

        <div class="container mt-3">
            <?php if($args["addCard"]): ?>
                <p class="text-danger">タイムカードを登録しました。</p>
            <?php endif; ?>
            <form class="form" method="POST">
                <?php if($args["isAdmin"]): ?>
                <div class="form-group row">
                    <div class="col-md-2">
                        <label for="username" class="form-label">ユーザー名</label>
                    </div>
                    <div class="col-md-7">
                        <select name="uid" id="username" class="form-select">
                            <option value="-1" disabled>◆ 選択してください ◆</option>
                            <?php foreach($args["users"] as $user): ?>
                            <?php if($user["id"] == $args["user"]["id"]): ?>
                            <option value="<?php echo $user["id"]; ?>" selected><?php echo $user["username"]; ?></option>
                            <?php else: ?>
                            <option value="<?php echo $user["id"]; ?>"><?php echo $user["username"]; ?></option>
                            <?php endif; ?>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-3 form-text">
                        タイムカードを登録したいユーザーを選択してください
                    </div>
                </div>
                <?php else: ?>
                <input type="hidden" name="uid" value="<?php echo $args["user"]["id"]; ?>" />
                <?php endif; ?>

                <div class="form-group row">
                    <div class="col-md-2">
                        打刻時刻
                    </div>
                    <div class="col-md-7">
                        <?php if($args["isAdmin"]): ?>
                        <input class="form-control" type="datetime" name="date" value="<?php echo date("Y-m-d H:i:s"); ?>" />
                        <?php else: ?>
                        <input class="form-control" type="datetime" name="date" value="<?php echo date("Y-m-d H:i:s"); ?>" readonly />
                        <?php endif; ?>
                    </div>
                    <div class="col-md-3 form-text">
                        打刻する時間になります。通常はそのままで問題ありません。
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-md-2">
                    </div>
                    <div class="col-md-7">
                        <button class="btn btn-primary" type="submit" name="reg" value="start">始業</button>
                        <button class="btn btn-primary" type="submit" name="reg" value="end">終業</button>
                        <button class="btn btn-primary" type="submit" name="reg" value="auto">登録</button>
                    </div>
                    <div class="col-md-3 form-text">
                    </div>
                </div>
            </form>
        </div>

        <?php if($args["isAdmin"]): ?>
        <div class="container mt-3">
            <form class="form" method="GET">
                <div class="form-group row">
                    <div class="col-md-6">
                        <select name="id" id="username" class="form-select">
                            <?php foreach($args["users"] as $user): ?>
                            <?php if($user["id"] == $args["user"]["id"]): ?>
                            <option value="<?php echo $user["id"]; ?>" selected><?php echo $user["username"]; ?></option>
                            <?php else: ?>
                            <option value="<?php echo $user["id"]; ?>"><?php echo $user["username"]; ?></option>
                            <?php endif; ?>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <button class="btn btn-success" type="submit">移動</button>
                    </div>
                    <div class="col-md-3 text-muted">
                        選択したユーザーのタイムカードを開きます。
                    </div>
                </div>
                <input type="hidden" name="p" value="view" />
            </form>
        </div>
        <?php endif; ?>
        
        <hr />

        <?php if($args["logged"]): ?>
        <div class="container mt-3">
            <?php if(empty($args["works"]) && !$args["lastCard"]): ?>
            <p class="text-danger">タイムカードは登録されていません。</p>
            <?php else: ?>
            <?php $hours = 0; $minutes = 0; ?>
            <div class="table-responsive">
                <table class="table table-hover table-bordered">
                    <tr>
                        <th>始業</th>
                        <th>終業</th>
                        <th>実働時間</th>
                    </tr>
                    <?php if($args["lastCard"] && $args["lastCard"]["endTime"] == NULL): ?>
                        <tr class="timecard">
                            <td><?php echo $args["lastCard"]["startTime"]; ?></td>
                            <td> - </td>
                            <td> - </td>
                        </tr>
                    <?php endif; ?>
                    <?php foreach ($args["works"] as $k => $v): ?>
                        <tr>
                            <td><?php echo $v["startTime"]; ?></td>
                            <td><?php echo $v["endTime"]; ?></td>
                            <td><?php echo $v["workHour"]; ?>h <?php echo $v["workMinutes"]; ?>m</td>
                        </tr>
                        <?php $hours += $v["workHour"]; ?>
                        <?php $minutes += $v["workMinutes"]; ?>
                        <?php if ($minutes >= 60) {
                            $hours += 1;
                            $minutes -= 60;
                        } ?>
                    <?php endforeach; ?>
                    <tr class="mt-1">
                        <th>合計</th>
                        <td><?php echo $hours; ?>h</td>
                        <td><?php echo $minutes; ?>m</td>
                    </tr>
                </table>
            </div>
            <?php endif; ?>
        </div>
        <?php endif; ?>

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
