<?php
session_start();
require_once( '../dbconnect.php' );

    if (!isset($_SESSION['register']['id'])) {
      header('../location: signin.php');
    }
    $signin_user_id = $_SESSION['register']['id'];
    //SELECTで現在サインインしているユーザーの情報をusersテーブルから読み込む
    $sql = 'SELECT `id`, `name`, `img_name` FROM `users` WHERE `id` = ?';
    $data = [$signin_user_id];
    $stmt = $dbh->prepare($sql);
    $stmt->execute($data);

    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    // 編集するpost_id
    $edit_feed_id = $_SESSION['feed_id'];
    // 編集処理
    
        // $edit_title = '';
        // $edit_post = '';
    if (!empty($_POST['update'])) {
        $edit_feed = $_POST['edit_feed'];

    $sql = 'UPDATE feeds SET feed = ? WHERE id = ?';
    $data = [$edit_feed,$edit_feed_id];
    $stmt = $dbh->prepare($sql);
    $stmt->execute($data);
    header('Location: ../mypage/mypage.php');
    exit();

    }

    $sql = 'SELECT * FROM feeds WHERE id = ? ';
    $data = [$edit_feed_id];
    $stmt = $dbh->prepare($sql);
    $stmt->execute($data);

    // フィード一覧を入れる配列
    $feed = '';
    // フェッチ
    $record = $stmt->fetch( PDO::FETCH_ASSOC );

    // レコードがあれば追加
    $feed = $record;

    ?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>BBSの編集</title>
</head>
<body>
  <h1>編集する</h1>
  <form action="bbs_edit.php" method="POST">
    <div>
      <label for="edit_bbs_feed">Detail</label>
      <input type="text" name="edit_feed" value="<?php echo $feed['feed']?>">
    </div>
    <div>
      <input type="submit" name="update" value="update" >
    </div>
  </form>
</body>
</html>