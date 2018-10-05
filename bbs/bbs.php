<?php
    session_start();
    require_once('../dbconnect.php');


    $feed_id = $_POST['feed_id'];

    $sql= 'SELECT f.*,u.name FROM feeds AS f LEFT JOIN users AS u ON f.user_id = u.id WHERE f.id = ?';
    $data = [$feed_id];
    $stmt = $dbh->prepare($sql);
    $stmt->execute($data);

    // フィード一覧を入れる配列
    $feed = '';
      // フェッチ
      $record = $stmt->fetch(PDO::FETCH_ASSOC);

      // レコードがあれば追加
      $feed = $record;

?>


<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>bbs 詳細</title>
</head>
<body>
  <div>
      <a href="feed.php">投稿する</a> 

        <div><?php echo $feed['name'] ?></div>
        <div><?php echo $feed['feed'] ?></div>
        <div><?php echo $feed['created'] ?></div>

        <a href="bbs_list.php">BBS一覧に戻る</a>

  </div>
</body>
</html>