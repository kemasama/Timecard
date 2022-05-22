
# Timecard

退勤管理などで使用できるタイムカードアプリです。

## 必要なもの

- MySQL サーバー
- PHPが動くウェブサーバー

## インストール方法

1. ウェブサイトにTimecardをアップロードします。
2. install.php にアクセスします。
3. インストールをクリックしてインストール作業を始めます。
4. 最後にインストーラー削除をクリックして完了です。

## 設定方法

1. config.sample.php をコピーし、そのファイルをconfig.phpに改名します。
2. mysqlの項目を設定します。
3. canonicalにはタイムカードを配置したURLを入力します。
4. heads にはスクリプトのソースなど、HEADタグないに自動追加したいタグなどを入力します。（必要なければそのままでOK）
5. admin_usersには管理者権限を持つユーザー名を入力します。例えば、作成したユーザー「root」に管理者権限を持たせるには、admin_usersに「root」を追加します。

## デザインの修正

template フォルダ内のファイルを修正します。

### view.php

メインで表示される画面です。

### create.php

ユーザー作成画面で表示される画面です。

### login.php

ユーザーログイン画面で表示される画面です。

### passwd.php

パスワード変更時に表示される画面です。

### error.php

サーバーエラー発生時に表示される画面です。

## システムの修正

provide フォルダ内のファイルを修正します。

### BootLoader.php

ページの追加などはBootLoaderを修正します。

## バグなど

メールとかSNSとか、issuesとかから報告してもらえたら修正すると思います。

## License

Bootstrap

[https://getbootstrap.jp/](https://getbootstrap.jp/)

