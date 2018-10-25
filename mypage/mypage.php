<?php
require( '../path.php' );
session_start();
require_once( '../dbconnect.php' );
require_once('function.php');

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

if ( !empty( $_POST[ 'blog_update' ] ) ) {
	$edit_post_id = $_POST['post_id'];
	$edit_title = $_POST[ 'edit_title' ];
	$edit_post = $_POST[ 'edit_post' ];

	$pictures = $_FILES[ 'blog_file' ][ 'name' ];
	$temps = $_FILES[ 'blog_file' ][ 'tmp_name' ];
	for ( $i = 0; $i < count( $_FILES[ 'blog_file' ][ 'name' ] ); $i++ ) {
		$picture = $_FILES[ 'blog_file' ][ 'name' ][ $i ];
		$temp = $_FILES[ 'blog_file' ][ 'tmp_name' ][ $i ];

		$data_str = date( 'YmdHis' );
		$submit_file_name = $data_str . $picture;

		move_uploaded_file( $temp, '../blog_img/' . $submit_file_name );


		$edit_post = preg_replace( '/selected_picture' . $picture . '/', '<img src="../blog_img/' . $submit_file_name . '">', $edit_post );}

	$sql = 'UPDATE posts SET title = ?, post = ? WHERE id = ?';
	$data = [ $edit_title, $edit_post, $edit_post_id ];
	$stmt = $dbh->prepare( $sql );
	$stmt->execute( $data );
}

// BBS編集
if ( !empty( $_POST[ 'bbs_update' ] ) ) {
	$edit_feed = $_POST[ 'edit_feed' ];
	$edit_feed_id = $_POST['feed_id'];

	$sql = 'UPDATE feeds SET feed = ? WHERE id = ?';
	$data = [ $edit_feed, $edit_feed_id ];
	$stmt = $dbh->prepare( $sql );
	$stmt->execute( $data );
	//    header('Location: ../mypage/mypage.php');
	// exit();

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
	//echo '<pre>';
	//var_dump($posts);
	//echo '</pre>';

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
$data = [ $signin_user_id ];
$stmt = $dbh->prepare( $sql );
$stmt->execute( $data );

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
$data = [ $signin_user_id ];
$stmt = $dbh->prepare( $sql );
$stmt->execute( $data );

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
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script src="../js/jquery-3.1.1.js"></script>
		<script>

		$( function () {
			$( document ).on( 'click', '.add_blog_file_btn', function () {
				const num = $( this ).attr( 'num' );
				const file = $( '.blog_file' )[ num ].files[ 0 ];
				console.log( file[ 'name' ] );
				// 		const blog_file = document.querySelector('.blog_file').files;
				// console.log(blog_file[num]['name']);

				const blog_text = document.querySelector( '#blog_text' ).value;
				document.querySelector( '#blog_text' ).value = blog_text + 'selected_picture' + file[ 'name' ];
			} )

			const btns = $( '.add_blog_file_btn' );
			let num = parseInt( $( btns[ btns.length - 1 ] ).attr( 'num' ), 10 );
			num++;
			$this = $( "#add_box" );
			$this.click( function ( e ) {
				e.preventDefault();
				let addHtml = '<input class="blog_file" type="file" name="blog_file[]"><input num="';
				addHtml += num;
				addHtml += '" class="add_blog_file_btn" type="button" value="INSERT IMAGE -本文に写真を挿入-"></p>';
				$this.before( addHtml );
			} );
		} );
	</script>

</head>
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
						<div class="userInfo">
							<ul>
								<li>
									<span>
										<?php echo $name?>
									</span>
									|<a href="../signout.php">sign out</a>
								</li>
								<li><a href="mypage_edit.php">ProfileEdit</a>
								</li>
								<li><button type="button" class="like"><i class="far fa-heart"></i></li>
							</ul>
						</div>
					</div>
				<!-- いいねしたBBS記事の出力 -->
				<div class="like_list">
						<section>
					<h3>BBS LIKE LIST</h3>
						<?php foreach ($liked_feeds as $liked_feed) :?>
							<form action="../bbs/bbs.php" method="POST">
								<ul>
									<li class="time"><?php echo $liked_feed['created']?></li>
									<li><?php echo $liked_feed['feed']?></li>
								</ul>
									<p>
										<input type="hidden" name="feed_id" value="<?php echo $liked_feed['feed_id']?>">
										<div class="check"><i class="fas fa-caret-right"></i><input type="submit" name="submit" value="CHECK"></div>
									</p>
								
							</form>
						<?php endforeach; ?>
							</section>
						<section>
							<!-- いいねしたBLOG記事の出力 -->
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
						</section>
					</article>
				<article class="secound_a">
					<h3>YOUR BLOG POSTS</h3>
					<section class="blw">
						<?php foreach ($posts as $post):?>
						<div class="blaw">
							<div class="blog_thum">
								<img src="<?php echo catch_that_image($post['post']); ?>">
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
									<!--ボタンが押された時に、$post['id']に記事のidを入れる。-->
									<?php echo '<pre>';
									//押した記事の'id'を取得
									var_dump($post['id']);
									echo '</pre>';?>
									<input type="hidden" name="post_id" value="<?php echo $post['id'] ?>">
									<input type="button" name="post_edit" value="EDIT" class="modal-open">
									<span>|</span>
									<input type="submit" name="post_delete" value="DELETE">
								</div>
							</form>
						</div>
						<?php endforeach; ?>
					<div id="modal-main">
						<!-- ここにeditを入れる -->
						<!-- blogの編集画面 -->
						<form action="mypage.php" method="POST" enctype="multipart/form-data">
							<?php echo '<pre>';
							//押した記事の'id'を取得
							var_dump($post['id']);
							//取得した'id'を数字に変換して、$posts[ここ]に入れる。
							var_dump($posts[0]);
							echo '</pre>';?>
						    <div>
						      <label for="edit_blog_title">Title</label>
						      <input type="text" name="edit_title" value="<?php echo /*押されたidのきじのタイトルを取り出す。*/$posts[1]['title']//$post['title']?>">
						    </div>
						    <div>
						      <label for="edit_blog_post">Detail</label>
						      <textarea id="blog_text" name="edit_post"><?php echo $post['post']?></textarea><br>
						      <input type="hidden" name="post_id" value="<?php echo $post['id']?>">

						      <input class="blog_file" type="file" name="blog_file[]">
									<input num="0" class="add_blog_file_btn" type="button" value="INSERT IMAGE-本文に写真を挿入-">
									<button id="add_box"><i class="far fa-images"></i>Add Image Box-写真の追加-</button>
						    </div>
						    <div>
						      <input type="submit" name="blog_update" value="update" >
						    </div>
						    <div>
						    	<p>画像の編集の仕方</p>
						    	<ol>
						    		
						    	<li>1.削除したい画像に対応した'img src'から始まる画像名を削除する</li>
						    	<li>2.新しく入れたい写真を選び、'INSERT IMAGE'ボタンを押してください。</li>
						    	<li>3.新しい写真の画像名が文末に表示されます。必要に応じて、場所を移動して使ってください。</li>
						    	<li>1.Plese delete the image name you want to change that start from 'img src'.</li>
						    	<li>2.Plese select a new pictute, and push 'INSERT IMAGE' button.</li>
						    	<li>A new image name will come in sight in the end of article. Plese move the image name to place you want to insert.</li>
						    	</li>
						    	</ol>
						    </div>
						</form>
					</div>
						<?php //endforeach; ?>
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
						      <input type="hidden" name="feed_id" value="<?php echo $feed['id']?>">
						      <textarea name="edit_feed"><?php echo $feed['feed']?></textarea>
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
			</div>
		<?php include ('../footer/footer.php'); ?>
	</body>
</html>