<?php
require( '../path.php' );
session_start();
require_once( '../dbconnect.php' );

// 閲覧制限
// サインイン処理をしていれば、セッション処理の中にidが保存されているので、idが存在するかどうかでこのタイムラインページの閲覧を制限する。
// echo '<pre>';
// var_dump ($_SESSION);
// echo '</pre>';
// die();
if ( !isset( $_SESSION[ 'register' ][ 'id' ] ) ) {
	header( '../location: signin.php' );
}
$signin_user_id = $_SESSION[ 'register' ][ 'id' ];
//SELECTで現在サインインしているユーザーの情報をusersテーブルから読み込む
$sql = 'SELECT `id`, `name`, `img_name` FROM `users` WHERE `id` = ?';
$data = [ $signin_user_id ];
$stmt = $dbh->prepare( $sql );
$stmt->execute( $data );

// ブログ編集
 if ( !empty( $_POST[ 'post_edit' ] ) ) {
 	$_SESSION[ 'post_id' ] = $_POST[ 'post_id' ];
// 	header( 'Location: ../blog/blog_edit.php' );
 }
    if (!empty($_POST['blog_update'])) {
        $edit_title = $_POST['edit_title'];
        $edit_post = $_POST['edit_post'];

    $sql = 'UPDATE posts SET title = ?, post = ? WHERE id = ?';
    $data = [$edit_title,$edit_post,$edit_post_id];
    $stmt = $dbh->prepare($sql);
    $stmt->execute($data);
    }

// BBS編集
 if ( !empty( $_POST[ 'feed_edit' ] ) ) {
 	$_SESSION[ 'feed_id' ] = $_POST[ 'feed_id' ];
// 	header( 'Location: ../bbs/bbs_edit.php' );
 }
     if (!empty($_POST['bbs_update'])) {
    $edit_feed = $_POST['edit_feed'];

    $sql = 'UPDATE feeds SET feed = ? WHERE id = ?';
    $data = [$edit_feed,$edit_feed_id];
    $stmt = $dbh->prepare($sql);
    $stmt->execute($data);
//    header('Location: ../mypage/mypage.php');
    exit();

    }

// ブログの削除処理
if ( !empty( $_POST[ 'post_delete' ] ) ) {
	$str_post_id = $_POST[ 'post_id' ];
	$post_id = ( int )$str_post_id;


	$sql = 'DELETE FROM `posts` WHERE `id` = ?';
	$data = [ $post_id ];
	$stmt = $dbh->prepare( $sql );
	$stmt->execute( $data );

}
// BBSの削除処理
if ( !empty( $_POST[ 'feed_delete' ] ) ) {
	$str_feed_id = $_POST[ 'feed_id' ];
	$feed_id = ( int )$str_feed_id;


	$sql = 'DELETE FROM `feeds` WHERE `id` = ?';
	$data = [ $feed_id ];
	$stmt = $dbh->prepare( $sql );
	$stmt->execute( $data );
}

$sql = 'SELECT * FROM `users` WHERE `id` = ?';
$data = [ $signin_user_id ];
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
$data = [ $signin_user_id ];
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
$data = [ $signin_user_id ];
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

// いいねしたBBS記事の出力

$sql = "SELECT u.id, l.*, f.* FROM feed_likes AS l LEFT JOIN users AS u ON u.id = l.user_id LEFT JOIN feeds AS f ON l.feed_id = f.id WHERE l.user_id = ?";
$data = [$signin_user_id];
$stmt = $dbh->prepare($sql);
$stmt->execute($data);

// ポストを入れる配列
$liked_feeds = array();
// レコードがなくなるまで取得処理
while ( true ) {
	// 1件ずつフェッチ
	$record = $stmt->fetch( PDO::FETCH_ASSOC );
	// レコードがなければ処理を抜ける
	if ( $record == false ) {
		break;
	}
	// レコードがあれば追加
	$liked_feeds[] = $record;
}

//いいねしたBLOG記事の出力
$sql = "SELECT u.id, l.*, p.* FROM post_likes AS l LEFT JOIN users AS u ON u.id = l.user_id LEFT JOIN posts AS p ON l.post_id = p.id WHERE l.user_id = ?";
$data = [$signin_user_id];
$stmt = $dbh->prepare($sql);
$stmt->execute($data);

// ポストを入れる配列
$liked_posts = array();
// レコードがなくなるまで取得処理
while ( true ) {
	// 1件ずつフェッチ
	$record = $stmt->fetch( PDO::FETCH_ASSOC );
	// レコードがなければ処理を抜ける
	if ( $record == false ) {
		break;
	}
	// レコードがあれば追加
	$liked_posts[] = $record;
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
	<title>mypage</title>
	<link rel="stylesheet" type="text/css" href="../css/style.css" media="screen">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.1/css/all.css" integrity="sha384-5sAR7xN1Nv6T6+dT2mhtzEpVJvfS3NScPQTrOxhwjIuvcA67KV2R5Jz6kr4abQsz" crossorigin="anonymous">

	<body>
		<header>
			<?php include ('../header/header.php'); ?>
		</header>
		<div id="mypageWrap">
			<div class="mpc">
				<h1><img src="img/mypagepng"></h1>
				<article>
					<div id="uinfo">
						<div class="user_img"><img src="../user_profile_img/<?= $user['img_name']?>" width="60" class="img-thumbnail">
						</div>
						<div class="edita">
							<h2>YOUR INFORMATION</h2>
							<form action="mypage_edit.php" method="GET">
								<ul class="isr">
									<li>IMEAGE SETTING<input type="submit" name="img_name" value="">
									</li>
									<li>PASS SETTING<input type="submit" name="password" value="">
									</li>
								</ul>
								<ul>
									<li>
										User Name:
										<?php echo $name?>
										<input type="submit" name="name" value="">
									</li>
									<li>
										E-mail:
										<?php echo $email?>
										<input type="submit" name="email" value="">
									</li>
									<li>
										gender:
										<?php echo $gender?>
										<input type="submit" name="gender" value="">
									</li>
									<li>
										age:
										<?php echo $age?>
										<input type="submit" name="age" value="">
									</li>
									<li>
										school:
										<?php echo $school?>
										<input type="submit" name="school" value="">
									</li>
									<li>
										introduction:
										<?php echo $other?>
										<input type="submit" name="other" value="">
									</li>
								</ul>
							</form>
							<p><a href="../signout.php">sign out</a>
							</p>
						</div>
					</div>
				</article>
				
				<!-- いいねしたBBS記事の出力 -->
				<div>
					<h3>BBS LIKE LIST</h3>
						<?php foreach ($liked_feeds as $liked_feed) :?>
							<form action="../bbs/bbs.php" method="POST">
								<div><?php echo $liked_feed['created']?></div>
								<div><?php echo $liked_feed['feed']?></div>
								<div><input type="hidden" name="feed_id" value="<?php echo $liked_feed['feed_id']?>"></div>
								<div><input type="submit" name="submit" value="CHECK"></div>
							</form>
						<?php endforeach; ?>
				</div>
				
				<!-- いいねしたBLOG記事の出力 -->
				<div>
					<h3>BLOG LIKE LIST</h3>
						<?php foreach ($liked_posts as $liked_post) :?>
							<form action="../blog/blog.php" method="POST">
								<div><?php echo $liked_post['created']?></div>
								<div><?php echo $liked_post['title'] ?></div>
								<div><?php echo $liked_post['post']?></div>
								<div><input type="hidden" name="post_id" value="<?php echo $liked_post['post_id']?>"></div>
								<div><input type="submit" name="submit" value="CHECK"></div>
							</form>
						<?php endforeach; ?>
				</div>

				<article class="secound_a">
					<h3>YOUR BLOG POSTS</h3>
					<section class="blw">
						<?php foreach ($posts as $post):?>
						<div class="blaw">
							<div class="blog_thum">
								<img src="img/ジンベイザメ横から.jpg">
							</div>
							<form action="mypage.php" method="POST">
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
									<input type="hidden" name="post_id" value="<?php echo $post['id'] ?>">
									<input type="button" name="post_edit" value="EDIT" class="modal-open">
									<span>|</span>
									<input type="submit" name="post_delete" value="DELETE">
								</div>
							</form>
						</div>
					<div id="modal-main">
						<!-- ここにeditを入れる -->
						<!-- blogの編集画面 -->
						<form action="mypage.php" method="POST">
						    <div>
						      <label for="edit_blog_title">Title</label>
						      <input type="text" name="edit_title" value="<?php echo $post['title']?>">
						    </div>
						    <div>
						      <label for="edit_blog_post">Detail</label>
						      <input type="text" name="edit_post" value="<?php echo $post['post']?>">
						    </div>
						    <div>
						      <input type="submit" name="blog_update" value="update" >
						    </div>
						</form>
					</div>
						<?php endforeach; ?>
					</section>
				</article>
				<article>
					<h3>YOUR BBS POSTS</h3>
					<section class="bbsw">
						<?php foreach ($feeds as $feed):?>
						<div class="bbsaw">
							<form action="mypage.php" method="POST">
								<span class="time">
									<?php echo $feed['created'] ?>
								</span>
								<div class="body">
									<?php echo $feed['feed'] ?>
								</div>
								<div class="ebtn">
									<input type="hidden" name="feed_id" value="<?php echo $feed['id'] ?>">
									<input type="button" name="feed_edit" value="EDIT" class="modal-openco">
									<span>|</span>
									<input type="submit" name="feed_delete" value="DELETE">
								</div>
							</form>
						</div>
						<div id="modal-mainCo">
						<form action="mypage.php" method="POST">
						    <div>
						      <label for="edit_bbs_feed">Detail</label>
						      <input type="text" name="edit_feed" value="<?php echo $feed['feed']?>">
						    </div>
						    <div>
						      <input type="submit" name="bbs_update" value="update" >
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