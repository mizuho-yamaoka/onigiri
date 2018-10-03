<?php
    // サインイン処理
   session_start();
    require_once('dbconnect.php');

echo '<pre>';
var_dump ($_POST);
echo '</pre>';

    // サインインボタンが押されたら
    // $_POSTが空でなければ
    $errors = [];
    $email = '';

    if (!empty($_POST)) {
        $email = $_POST['email'];
        $password = $_POST['password'];
        // バリデーション（emailとpasswordの入力空チェック）
        if ($email != '' && $password != '') {
            // データベースとの照合
            // 入力されたメールアドレスとパスワードの組み合わせがusersテーブルに存在するか
                // SELECT文を使ってレコードを読み込む
                    // 一致するデータがあるかどうか（存在）するかどうか
            // ①SQL文の文字をセットする
            $sql = 'SELECT * FROM `users` WHERE `email` = ?';
            // ②SQL文に含みたいデータを配列で用意する(タプル処理)
            $data = [$email]; 
            // ③SQL文の文字をprepare()にセットする
            $stmt = $dbh->prepare($sql);
            // ④実行する
            $stmt->execute($data);
            
            // 使えない→使えるデータに変換したい
            // フェッチする　fetch()
                // object型→Array型に変換する処理
            $record = $stmt->fetch(PDO::FETCH_ASSOC);
            // echo '<pre>';
            // var_dump ($record);
            // echo '</pre>';
            // 登録されたメールアドレスかチェック
            if ($record == false) {
                $errors['signin'] = 'failed';
            }
            // パスワードが一致するかチェック
            // $record['password']はDBから取ってきたパスワード
            if (password_verify($password,$record['password'])) {
                  // 認証成功
                  // サインインするユーザーのIDをセッションに保存
              $_SESSION['cebufull']['id'] = $record['id'];
              header('Location: blog_list.php');
            }else{
                // 認証失敗
              $errors['signin'] = 'failed';
            }
            echo '<pre>';
            var_dump ($errors['signin']);
            echo '</pre>';


            // SELECT文でメールアドレスとパスワードが一致するレコードをusersテーブルから読み込む
            // データが1件読み込めれば存在するデータということでOK
            // データが0件ならメールアドレスとパスワードの組み合わせが間違っっているということでNG
        }else{
            // エラーを出す
            $errors['signin'] = 'blank';
        }
    }


?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <title>Learn SNS</title>
  <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.css">
  <link rel="stylesheet" type="text/css" href="assets/font-awesome/css/font-awesome.css">
  <link rel="stylesheet" type="text/css" href="assets/css/style.css">
</head>
<body style="margin-top: 60px">
  <div class="container">
    <div class="row">
      <div class="col-xs-8 col-xs-offset-2 thumbnail">
        <h2 class="text-center content_header">サインイン</h2>
        <form method="POST" action="" enctype="multipart/form-data">
          <div class="form-group">
            <label for="email">メールアドレス(Email)</label>
            <input type="email" name="email" class="form-control" id="email" placeholder="example@gmail.com">
          </div>
          <div class="form-group">
            <label for="password">パスワード(Password)</label>
            <input type="password" name="password" class="form-control" id="password" placeholder="4 ~ 16文字のパスワード">
          </div>
          <input type="submit" class="btn btn-info" value="サインイン">
        </form>
      </div>
    </div>
  </div>
  <script src="assets/js/jquery-3.1.1.js"></script>
  <script src="assets/js/jquery-migrate-1.4.1.js"></script>
  <script src="assets/js/bootstrap.js"></script>
</body>
</html>