<?php
require( '../path.php' );
session_start();
require_once( '../dbconnect.php' );

	$signin_user_id = '';
if ( isset( $_SESSION[ 'register' ][ 'id' ] ) ) {
	$signin_user_id = $_SESSION[ 'register' ][ 'id' ];
}

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

$likes_flg_sql = 'SELECT * FROM `post_likes` WHERE `user_id` = ? AND `post_id` = ?';
$likes_flg_data = [ $signin_user_id, $record[ 'id' ] ];
$likes_flg_stmt = $dbh->prepare( $likes_flg_sql );
$likes_flg_stmt->execute( $likes_flg_data );
$is_liked = $likes_flg_stmt->fetch( PDO::FETCH_ASSOC );
// 三項演算子
// 条件式 ? 真の場合:偽の場合;
$record[ 'is_liked' ] = $is_liked ? true : false;

// 投稿に対して何件いいねされているか取得
$like_sql = 'SELECT COUNT(*) AS `like_count` FROM `post_likes` WHERE `post_id` = ?';
$like_data = [ $record[ 'id' ] ];
$like_stmt = $dbh->prepare( $like_sql );
$like_stmt->execute( $like_data );
$result = $like_stmt->fetch( PDO::FETCH_ASSOC );

// feed１件ごとにいいねの数を新しく入れる
$record[ 'like_count' ] = $result[ 'like_count' ];
// レコードがあれば追加
$post = $record;
?>


<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="UTF-8">
	<title>cebufull blog</title>
	<link rel="stylesheet" type="text/css" href="../css/style.css" media="screen">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.1/css/all.css" integrity="sha384-5sAR7xN1Nv6T6+dT2mhtzEpVJvfS3NScPQTrOxhwjIuvcA67KV2R5Jz6kr4abQsz" crossorigin="anonymous">
	<!--font-->
	<link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
</head>

<body>
	<header>
		<?php include ('../header/header.php'); ?>
	</header>
	<div class="atop">
		<article>
			<section>
				<h1 class="btotle">
					<?php echo $post['title'] ?>
				</h1>
				<ul>
					<li>writer:
						<?php echo $post['name'] ?>
					</li>
					<li><span>|</span>
					</li>
					<li>
						<?php echo $post['created'] ?>
					</li>
				</ul>
			</section>
		</article>
	</div>
	<div class="blogWrap">
		<div class="blat">
			<?php echo $post['post'] ?>
		</div>
		<div class="opt">
			<a href="post.php"><i class="fas fa-pencil-alt"></i>投稿する</a>
			<span>|</span>
			<div>
				<?php if(isset($_SESSION['register']['id'])): ?>
				<?php if($post['is_liked']):?>
				<button class="js-unlike"><span><i class="fas fa-thumbs-up"></i></span></button>
				<?php else :?>
				<button class="js-like"><span><i class="far fa-thumbs-up"></i></span></button>
				<?php endif ;?>
				<span hidden class="user_id"><?php echo $signin_user_id;?></span>
				<span hidden class="post_id"><?php echo $post['id'];?></span>
				<span class="like-count">
					<?php echo $post['like_count'] ?>
				</span><br>
				<?php endif ;?>
			</div>
		</div>
			<div class="list_back">
				<a href="blog_list.php">&#171;Go back</a>
			</div>
	</div>
	<?php include ('../footer/footer.php'); ?>
	<script type="text/javascript" src="../js/blog_app.js"></script>
</body>
</html>