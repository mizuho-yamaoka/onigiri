<?php
require( '../path.php' );
require('../bbs/function.php');
if ( !isset( $_SESSION ) ) {
	session_start();
}

require_once( '../dbconnect.php' );

// 閲覧制限
// サインイン処理をしていれば、セッション処理の中にidが保存されているので、idが存在するかどうかでこのタイムラインページの閲覧を制限する。
if ( empty( $_SESSION ) || !isset( $_SESSION[ 'register' ][ 'id' ] ) ) {
	header( 'Location: ../signin.php' );
	exit();
}

$signin_user_id = $_SESSION[ 'register' ][ 'id' ];
//SELECTで現在サインインしているユーザーの情報をusersテーブルから読み込む
$sql = 'SELECT `id`, `name`, `img_name` FROM `users` WHERE `id` = ?';
$data = [ $signin_user_id ];
$stmt = $dbh->prepare( $sql );
$stmt->execute( $data );

// フェッチする
$user = $stmt->fetch( PDO::FETCH_ASSOC );

// 画像挿入機能



// 投稿機能
// エラーがあれば、この中に入れる
$errors = [];
$category = '';
$post = '';
$title = '';
// ポスト送信できたら
// テキストエリアの内容を取り出す

if ( !empty( $_POST ) ) {
	$username = $_POST[ 'username' ];
	$title = $_POST[ 'title' ];
	$post = $_POST[ 'body' ];

	$post = str_replace(array("\r", "\n"), "<br />", $post);

	$pictures = $_FILES[ 'blog_file' ][ 'name' ];
	$temps = $_FILES[ 'blog_file' ][ 'tmp_name' ];
	for ( $i = 0; $i < count( $_FILES[ 'blog_file' ][ 'name' ] ); $i++ ) {
		$picture = $_FILES[ 'blog_file' ][ 'name' ][ $i ];
		$temp = $_FILES[ 'blog_file' ][ 'tmp_name' ][ $i ];

		$data_str = date( 'YmdHis' );
		$submit_file_name = $data_str . $picture;

		move_uploaded_file( $temp, '../blog_img/' . $submit_file_name );


	$post = preg_replace( '/selected_picture' . $picture . '/', '<img src="../blog_img/' . $submit_file_name . '">', $post );


	}

	if ( isset( $_POST[ 'category' ] ) ) {
		$category = $_POST[ 'category' ];
	}
	// $category = $_POST[ 'category' ];

	//バリデーション処理
	// 投稿の空チェック
	if ( $post == '' ) {
		$errors[ 'post' ] = 'blank';
	}

	if ( $title == '' ) {
		$errors[ 'title' ] = 'blank';
	}
	if ( !isset( $_POST[ 'category' ] ) ) {
		$errors[ 'category' ] = 'not_chosen';
	}
	if ( empty( $errors ) ) {

		// 投稿処理
		$sql = 'INSERT INTO `posts` SET `title`= ?, `post`= ?, `user_id`= ?, `category_id`= ?, `created` = NOW()';
		$data = [ $title, $post, $username, $category ];
		$stmt = $dbh->prepare( $sql );
		$stmt->execute( $data );

		header( 'Location: blog_list.php' );
		exit();
	}
}

?>

<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="UTF-8">
	<title>ブログ投稿</title>
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
			$this = $( "#add_box" );
			$this.click( function ( e ) {
				e.preventDefault();
				num++;
				console.log(num);
				let addHtml = '<p><input class="blog_file" type="file" name="blog_file[]"></p><p><input num="';
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
	<div class="formWrap">
		<h1><img src="img/article.png"></h1>
		<article>
			<section class="l_user">
				<div class="writer">
					<h2>WRITER</h2>
					<img src="../user_profile_img/<?= $user['img_name']?>" class="img-thumbnail">
					<p>
						<?php echo $user['name']?>
					</p>
				</div>
			</section>
			<section class="bl_input">
				<form action="" method="POST" enctype="multipart/form-data">
					<input type="hidden" name="username" value="<?php echo $user['id']; ?>">

					<div class="title">
						<p>TITLE</p>
						<input type="text" name="title" placeholder="Title" value="<?php echo $title ?>">
					</div>
					<div class="contents">
						<p>CONTENTS</p>
						<textarea id="blog_text" type="text" name="body" placeholder="Body of letter"><?php echo change_indention_php($post) ?></textarea>
					</div>
					<div class="pict">
						<p>INSERT IMAGE</p>
						<p><input class="blog_file" type="file" name="blog_file[]"></p>
						<p><input num="0" class="add_blog_file_btn" type="button" value="INSERT IMAGE-本文に写真を挿入-"></p>
						<button id="add_box"><i class="far fa-images"></i>Add Image Box-写真の追加-</button>
						</ul>
					</div>
					<div class="acte">
						<p>CATEGORY</p>
						<input type="radio" name="category" value="1">EAT
						<input type="radio" name="category" value="2">ACTIVITY
						<input type="radio" name="category" value="3">LIFE
						<input type="radio" name="category" value="4">OTHER
					</div>
					<?php if(isset($errors['title']) && $errors['title'] == 'blank'): ?>
					<p class="red">タイトルを入力して下さい</p>
					<?php endif; ?>
					<?php if(isset($errors['post']) && $errors['post'] == 'blank'): ?>
					<p class="red">投稿データを入力して下さい</p>
					<?php endif; ?>
					<?php if(isset($errors['category']) && $errors['category'] == 'not_chosen'): ?>
					<p class="red">カテゴリーを選択して下さい</p>
					<?php endif; ?>
					<div class="thbtn">
						<input type="submit" value="POST">
					</div>
				</form>
			</section>
		</article>
		<div class="list_back">
			<a href="blog_list.php">&#171;Back</a>
		</div>
	</div>
	<?php include ('../footer/footer.php'); ?>
</body>
</html>