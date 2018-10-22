<?php
require( '../path.php' );
session_start();
require_once( '../dbconnect.php' );
require_once( 'function.php' );

if ( isset( $_SESSION[ 'register' ][ 'id' ] ) ) {
	$signin_user_id = $_SESSION[ 'register' ][ 'id' ];
	$sql = 'SELECT * FROM users WHERE id = ?';
	$data = [ $signin_user_id ];
	$stmt = $dbh->prepare( $sql );
	$stmt->execute( $data );

	$user = $stmt->fetch( PDO::FETCH_ASSOC );
}

if ( isset( $_SESSION[ 'feed_id' ] ) ) {
	$feed_id = $_SESSION[ 'feed_id' ];
}
if ( isset( $_POST[ 'feed_id' ] ) ) {
	$feed_id = $_POST[ 'feed_id' ];
}

$sql = 'SELECT f.*,u.name, u.email FROM feeds AS f LEFT JOIN users AS u ON f.user_id = u.id WHERE f.id = ?';
$data = [ $feed_id ];
$stmt = $dbh->prepare( $sql );
$stmt->execute( $data );

// フィード一覧を入れる配列
$feed = '';
// フェッチ
$record = $stmt->fetch( PDO::FETCH_ASSOC );

// ログインしているユーザーがその投稿をしているか確認
$likes_flg_sql = 'SELECT * FROM `feed_likes` WHERE `user_id` = ? AND `feed_id` = ?';
$likes_flg_data = [ $record[ 'user_id' ], $record[ 'id' ] ];
$likes_flg_stmt = $dbh->prepare( $likes_flg_sql );
$likes_flg_stmt->execute( $likes_flg_data );
$is_liked = $likes_flg_stmt->fetch( PDO::FETCH_ASSOC );
// 三項演算子
// 条件式 ? 真の場合:偽の場合;
$record[ 'is_liked' ] = $is_liked ? true : false;

// 投稿に対して何件いいねされているか取得
$like_sql = 'SELECT COUNT(*) AS `like_count` FROM `feed_likes` WHERE `feed_id` = ?';
$like_data = [ $record[ 'id' ] ];
$like_stmt = $dbh->prepare( $like_sql );
$like_stmt->execute( $like_data );
$result = $like_stmt->fetch( PDO::FETCH_ASSOC );

// feed１件ごとにいいねの数を新しく入れる
$record[ 'like_count' ] = $result[ 'like_count' ];
// feed１件ごとのコメント一覧を取得する
$record[ 'comments' ] = get_comments( $dbh, $record[ 'id' ] );
$record[ 'comment_count' ] = count_comments( $dbh, $record[ 'id' ] );

// レコードがあれば追加
$feed = $record;

?>


<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="UTF-8">
	<title>bbs 詳細</title>
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.1/css/all.css" integrity="sha384-5sAR7xN1Nv6T6+dT2mhtzEpVJvfS3NScPQTrOxhwjIuvcA67KV2R5Jz6kr4abQsz" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="../css/style.css">
</head>

<body>
	<header>
		<?php include ('../header/header.php'); ?>
	</header>
	<div class="bbsuse">
		<div class="useCo">
			<h1><img src="img/howtobbs.png"></h1>
			<dl>
				<dt>
					「もっと人数がいたらこのアクティビティ安くなるのに...」<br>
					「他の学校の人と交流したいな」
				</dt>
			
				<dd><img src="img/think.png">
				</dd>
				<dd class="arrow"><img src="img/arrow.png">
				</dd>
			</dl>
			<dl>
				<dt>
					<span>募集しよう！</span><br>
					<i class="fas fa-check"></i>やりたいこと（ツアーなら詳細）
					<i class="fas fa-check"></i>日程
					<i class="fas fa-check"></i>募集人数等を記入
				</dt>
			
				<dd><img src="img/write.png">
				</dd>
				<dd class="arrow"><img src="img/arrow.png">
				</dd>
			</dl>
			<dl>
				<dt>
					<span>参加したい！</span><br>
					<i class="far fa-hand-point-right"></i>コメントで質問！
					<i class="far fa-hand-point-right"></i>JOINボタンから主催者へコンタクトをとる！
					<p>※連絡先送信後主催者からの返信をお待ちください</p>
					<p>※なお、コミニュティでのアクティビティの実施に関しましては皆さま自身でのやりとりでお願いします。</p>
				</dt>
			
				<dd><img src="img/think.png">
				</dd>
				<dd class="arrow"><img src="img/arrow.png">
				</dd>
			</dl>
			<dl>
				<dt><span>Let's Enjoy!</span></dt>
				<dd><img src="img/join.png">
				</dd>
			</dl>
		</div><!--useCo-->
	</div><!--bbsuse-->
	<div class="bbsWrap">
		<div class="bpcWrap">
			<article class="bpc">
				<section>
					<div class="bbsCheader">
						<div>
							<a href="bbs_people.php?id=<?php echo $feed['user_id']?>">
								<?php echo $feed ['name'] ?>
							</a>
						</div>
						<div>
							<?php echo $feed['created'] ?>
						</div>
					</div>
					<div class="body">
						<?php echo $feed['feed'] ?>
					</div>
					<div class="opt">
						<a href="feed.php"><i class="fas fa-pencil-alt"></i>投稿する</a>
						<span>|</span>
						<div>
							<!-- いいね!ボタン -->
							<?php if(isset($_SESSION['register']['id'])): ?>
							<?php if($feed['is_liked']):?>
							<button class="js-unlike"><span><i class="fas fa-thumbs-up"></i></span></button>
							<?php else :?>
							<button class="js-like"><span><i class="far fa-thumbs-up"></i></span></button>
							<span hidden class="user-id">
								<?php echo $signin_user_id;?>
							</span>
							<span hidden class="feed-id">
								<?php echo $feed['id'];?>
							</span>
							<span class="like-count">
								<?php echo $feed['like_count'] ?>
							</span>
						</div>
					</div>
				</section>
				<?php endif; ?>
			</article>
			<article class="bpc_2">
				<section>
					<div class="post">
						<!-- コメント機能 -->
						<?php include('comment_view.php'); ?>
						<!-- JOIN -->
						<a href="#collapseComment<?php echo $feed['id'] ?>" data-toggle="collapse" aria-expanded="false"><span>JOIN</span></a>
						<?php include('email_form.php'); ?>
						<?php endif; ?>
					</div>
				</section>
			</article>
		</div>
			<div class="list_back">
				<a href="bbs_list.php">&#171;Go back</a>
			</div>
	</div>
	
	<?php include ('../footer/footer.php'); ?>
	<!-- 使う場合は３つのファイルのコピーをグループワークのファイルに作るのと、パス設定が必要です -->
	<script type="text/javascript" src="../js/jquery-3.1.1.js"></script>
	<script type="text/javascript" src="../js/jquery-migrate-1.4.1.js"></script>
	<script type="text/javascript" src="../js/bootstrap.js"></script>
	<script type="text/javascript" src="../js/bbs_app.js"></script>
</body>
</html>