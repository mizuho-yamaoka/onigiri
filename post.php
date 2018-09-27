<?php
session_start();
    require_once('dbconnect.php');
    // 閲覧制限
    // サインイン処理をしていれば、セッション処理の中にidが保存されているので、idが存在するかどうかでこのタイムラインページの閲覧を制限する。
    if (!isset($_SESSION['']['id'])) {
      header('location: signin.php');
    }
    $signin_user_id = $_SESSION['']['id'];
    //SELECTで現在サインインしているユーザーの情報をusersテーブルから読み込む
    $sql = 'SELECT `id`, `name`, `img_name` FROM `users` WHERE `id` = ?';
    $data = [$signin_user_id];
    $stmt = $dbh->prepare($sql);
    $stmt->execute($data);

    // フェッチする
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // 投稿機能
    // エラーがあれば、この中に入れる
    $errors = [];
    // ポスト送信できたら
    if (!empty($_POST)) {
      // テキストエリアの内容を取り出す
      $feed = $_POST['feed'];
      //バリデーション処理
      // 投稿の空チェック
      if ($feed != '') {
        // 空じゃなければ
        // 投稿処理
        $sql = 'INSERT INTO `feeds` SET `feed`= ?, `user_id`= ?, `created` = NOW()';
        $data = [$feed,$user['id']];
        $stmt = $dbh->prepare($sql);
        $stmt->execute($data);

        header('Location: timeline.php');
        exit();
      }else
        // 空だったら
        $errors['feed'] = 'blank';
    }








?>