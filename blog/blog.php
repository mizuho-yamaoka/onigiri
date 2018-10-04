<?php
    session_start();
    require_once('../dbconnect.php');
    $sql= 'SELECT `p`.*, `u`.`name` FROM `posts` AS `p` LEFT JOIN `users` AS `u` ON `p`.`user_id` = `u`.`id` ORDER BY `p`.`created` DESC';
    $stmt = $dbh->prepare($sql);
    $stmt->execute();

    // フィード一覧を入れる配列
    $feeds = array();
    // レコードがなくなるまで取得処理
    while(true){
      // １件ずつフェッチ
      $record = $stmt->fetch(PDO::FETCH_ASSOC);
      // レコードがなければ処理を抜ける
      if($record == false){
        break;
      }
      // レコードがあれば追加
      $feeds[] = $record;
    }


?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>test2</title>
</head>
<body>
  <div>
    <?php foreach ($feeds as $feed):?>
        <!-- 1件づつ処理 -->
       <!--  <img src="user_profile_img/<?= $feed['img_name']?>" width="40" class="img-thumbnail"> -->
        <div><?php echo $feed['name'] ?></div>
        <div><?php echo $feed['created'] ?></div>
        <div><?php echo $feed['post'] ?></div>
    <?php endforeach; ?>
  </div>
</body>
</html>