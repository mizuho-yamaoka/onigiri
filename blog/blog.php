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
			<a href="blog_list.php">ブログ一覧に戻る</a>
		</div>
	</article>
	<?php include ('../footer/footer.php'); ?>
</body>
</html>