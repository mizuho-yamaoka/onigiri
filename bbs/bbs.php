<?php
require( '../path.php' );
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

// echo '<pre>';
// var_dump($record);
// echo '</pre>';
// die();
      // ログインしているユーザーがその投稿をしているか確認

      $likes_flg_sql = 'SELECT * FROM `feed_likes` WHERE `user_id` = ? AND `feed_id` = ?';
      $likes_flg_data = [$record['user_id'],$record['id']];
      $likes_flg_stmt = $dbh->prepare($likes_flg_sql);
      $likes_flg_stmt->execute($likes_flg_data);
      $is_liked = $likes_flg_stmt->fetch(PDO::FETCH_ASSOC);
      // 三項演算子
      // 条件式 ? 真の場合:偽の場合;
      $record['is_liked'] = $is_liked ? true : false;

      // レコードがあれば追加
      $feed = $record;
?>


<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>bbs 詳細</title>
	<link rel="stylesheet" type="text/css" href="../css/style.css">
</head>
<body>
<header>
	<?php include ('../header/header.php'); ?>
</header>
	<div class="topimg_b"></div>
  <div class="bbsWrap">
      <a href="feed.php">投稿する</a> 
        <div><?php echo $feed['name'] ?></div>
        <div><?php echo $feed['feed'] ?></div>
        <div><?php echo $feed['created'] ?></div>

        <!-- いいね!ボタン -->
        <?php if($feed['is_liked']):?>
        <button class="js-unlike"><span>いいねを取り消す</span></button>
        <?php else :?>
        <button class="js-like"><span>いいね！</span></button>
        <?php endif ;?>


        <a href="bbs_list.php">BBS一覧に戻る</a>
  </div>
		<?php include ('../footer/footer.php'); ?>
<!-- 使う場合は３つのファイルのコピーをグループワークのファイルに作るのと、パス設定が必要です -->
    <script type="text/javascript" src="assets/js/jquery-3.1.1.js"></script>
    <script type="text/javascript" src="assets/js/jquery-migrate-1.4.1.js"></script>
    <script type="text/javascript" src="assets/js/bootstrap.js"></script>
    <script type="text/javascript" src="assets/js/bbs_app.js"></script>
</body>
</html>