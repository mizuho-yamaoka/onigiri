<?php
require( '../path.php' );
session_start();
require_once( '../dbconnect.php' );
require_once('function.php');

// 閲覧制限
// サインイン処理をしていれば、セッション処理の中にidが保存されているので、idが存在するかどうかでこのタイムラインページの閲覧を制限する。

if ( !isset( $_SESSION[ 'register' ][ 'id' ] ) ) {
	header( '../location: signin.php' );
}

$bbs_people = $_GET[ 'id' ];
//SELECTで現在サインインしているユーザーの情報をusersテーブルから読み込む
$sql = 'SELECT `id`, `name`, `img_name` FROM `users` WHERE `id` = ?';
$data = [ $bbs_people ];
$stmt = $dbh->prepare( $sql );
$stmt->execute( $data );

$sql = 'SELECT * FROM `users` WHERE `id` = ?';
$data = [ $bbs_people ];
$stmt = $dbh->prepare( $sql );
$stmt->execute( $data );

$user = $stmt->fetch( PDO::FETCH_ASSOC );

$name = $user[ 'name' ];
$email = $user[ 'email' ];
$img_name = $user[ 'img_name' ];
$gender = $user[ 'gender' ];
$age = $user[ 'age' ];
$school = $user[ 'school' ];
$other = $user[ 'other' ];

$sql = 'SELECT `p`.* FROM `posts`AS `p` LEFT JOIN `users` AS `u` ON `p`. `user_id`= `u`.`id` WHERE u.`id` = ?';
$data = [ $bbs_people ];
$stmt = $dbh->prepare( $sql );
$stmt->execute( $data );

// ポストを入れる配列
$posts = array();
// レコードがなくなるまで取得処理
while ( true ) {
	// 1件ずつフェッチ
	$record = $stmt->fetch( PDO::FETCH_ASSOC );
	// レコードがなければ処理を抜ける
	if ( $record == false ) {
		break;
	}
	// レコードがあれば追加
	$posts[] = $record;
}

$sql = 'SELECT `f`.* FROM `feeds`AS `f` LEFT JOIN `users` AS `u` ON `f`. `user_id`= `u`.`id` WHERE u.`id` = ?';
$data = [ $bbs_people ];
$stmt = $dbh->prepare( $sql );
$stmt->execute( $data );

// ポストを入れる配列
$feeds = array();
// レコードがなくなるまで取得処理
while ( true ) {
	// 1件ずつフェッチ
	$record = $stmt->fetch( PDO::FETCH_ASSOC );
	// レコードがなければ処理を抜ける
	if ( $record == false ) {
		break;
	}
	// レコードがあれば追加
	$feeds[] = $record;
}

// $genderの文字化
if ( $gender == '1' ) {
	$gender = 'Male';
} elseif ( $gender == '2' ) {
	$gender = 'Female';
} else {
	$gender = 'Not Chosen';
}

?>

<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="UTF-8">
	<title>投稿者情報</title>
	<link rel="stylesheet" type="text/css" href="../css/style.css">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.1/css/all.css" integrity="sha384-5sAR7xN1Nv6T6+dT2mhtzEpVJvfS3NScPQTrOxhwjIuvcA67KV2R5Jz6kr4abQsz" crossorigin="anonymous">
</head>

<body>
	<header>
		<?php include ('../header/header.php'); ?>
	</header>
	<div id="mypageWrap">
		<div class="mpc">
			<h1><img src="img/people.png"></h1>
			<div id="uinfo">
				<article class="bmpc">
					<div class="user_img">
						<img src="../user_profile_img/<?= $user['img_name']?>" width="60" class="img-thumbnail"><br>
					</div>
					<div class="info">
						<ul>
							<li>User Name:
								<span>
									<?php echo $name?>
								</span>
							</li>
							<li>gender:
								<span>
									<?php echo $gender?>
								</span>
							</li>
							<li>age:
								<span>
									<?php echo $age?>
								</span>
							</li>
							<li>school:
								<span>
									<?php echo $school?>
								</span>
							</li>
							<li>introduction:
								<span>
									<?php echo $other?>
								</span>
							</li>
						</ul>
					</div>
				</article>
			</div>
			<article class="secound_a">
				<h3>BLOG POSTS</h3>
				<section class="blw">
					<?php foreach ($posts as $post):?>
					<div class="blaw">
						<div class="blog_thum">
							<img src="<?php echo catch_that_image($post['post']); ?>">
						</div>
						<form action="../blog/blog.php" method="POST">
							<input type="hidden" name="post_id" value="<?php echo $post['id'] ?>">
							<span class="time">
								<?php echo $post['created'] ?>
							</span>
							<div class="title">
								<?php echo $post['title'] ?>
							</div>
							<div class="body">
								<?php echo $post['post'] ?>
							</div>
							<div class="ebtn">
								<i class="fas fa-caret-right"></i><input type="submit" name="submit" value="More read">
							</div>
						</form>
					</div>
					<?php endforeach; ?>
				</section>
			</article>
			<article>
				<h3>BBS POSTS</h3>
				<section class="bbsw">
					<?php foreach ($feeds as $feed):?>
					<div class="bbsaw">
						<form action="bbs.php" method="POST">
							<input type="hidden" name="feed_id" value="<?php echo $feed['id'] ?>">
							<span class="time">
								<?php echo $feed['created'] ?>
							</span>
							<div class="body">
								<?php echo $feed['feed'] ?>
							</div>
							<div class="ebtn">
								<i class="fas fa-caret-right"></i><input type="submit" name="submit" value="CHECK">
							</div>
						</form>
					</div>
					<?php endforeach; ?>
				</section>
			</article>
		</div>
	</div>
	<?php include ('../footer/footer.php'); ?>

</body>
</html>