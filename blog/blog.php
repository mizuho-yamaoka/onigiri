<?php
require( '../path.php' );
session_start();
require_once( '../dbconnect.php' );

$post_id = $_POST[ 'post_id' ];

$sql = 'SELECT p.*,u.name FROM posts AS p LEFT JOIN users AS u ON p.user_id = u.id WHERE p.id = ?';
$data = [ $post_id ];
$stmt = $dbh->prepare( $sql );
$stmt->execute( $data );

// フィード一覧を入れる配列
$post = '';
// フェッチ
$record = $stmt->fetch( PDO::FETCH_ASSOC );

// ログインしているユーザーがその投稿をしているか確認

$likes_flg_sql = 'SELECT * FROM `post_likes` WHERE `user_id` = ? AND `feed_id` = ?';
$likes_flg_data = [$record['user_id'],$record['id']];
$likes_flg_stmt = $dbh->prepare($likes_flg_sql);
$likes_flg_stmt->execute($likes_flg_data);
$is_liked = $likes_flg_stmt->fetch(PDO::FETCH_ASSOC);
// 三項演算子
// 条件式 ? 真の場合:偽の場合;
$record['is_liked'] = $is_liked ? true : false;
// レコードがあれば追加
$post = $record;
?>


<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="UTF-8">
	<title>test2</title>
	<link rel="stylesheet" type="text/css" href="../css/style.css">
</head>

<body>
	<header>
		<?php include ('../header/header.php'); ?>
	</header>
	<div class="topimg"></div>
	<article>
		<div class="blogWrap">
			<section>
				<div class="blch">
					<a href="post.php">投稿する</a>
					<div class="bname">
						<?php echo $post['name'] ?>
					</div>
					<div class="bcreated">
						<?php echo $post['created'] ?>
					</div>
				</div>
				<h1 class="btotle">
					<?php echo $post['title'] ?>
				</h1>
				<div>
					<?php echo $post['post'] ?>
				</div>
			</section>
				<div>
					<?php if($feed['is_liked']):?>
					<button class="js-unlike"><span>いいねを取り消す</span></button>
					<?php else :?>
					<button class="js-like"><span>いいね！</span></button>
					<?php endif ;?>
				</div>
			<a href="blog_list.php">ブログ一覧に戻る</a>
		</div>
	</article>
	<?php include ('../footer/footer.php'); ?>
<!-- 使う場合は３つのファイルのコピーをグループワークのファイルに作るのと、パス設定が必要です -->
<!--     <script type="text/javascript" src="assets/js/jquery-3.1.1.js"></script>
    <script type="text/javascript" src="assets/js/jquery-migrate-1.4.1.js"></script>
    <script type="text/javascript" src="assets/js/bootstrap.js"></script>
    <script type="text/javascript" src="assets/js/app.js"></script> -->
</body>
</html>