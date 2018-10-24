<?php
require( '../path.php' );
session_start();
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


// 投稿機能
// エラーがあれば、この中に入れる
$errors = [];
// ポスト送信できたら
if ( !empty( $_POST ) ) {
	// テキストエリアの内容を取り出す
	$username = $_POST[ 'username' ];
	$feed = $_POST[ 'body' ];

	//バリデーション処理
	// 投稿の空チェック
	if ( $feed != '' ) {
		// 空じゃなければ
		// 投稿処理
		$sql = 'INSERT INTO `feeds` SET `feed`= ?, `user_id`= ?, `created` = NOW()';
		$data = [ $feed, $username ];
		$stmt = $dbh->prepare( $sql );
		$stmt->execute( $data );

		header( 'Location: bbs_list.php' );
		exit();
	} else
	// 空だったら
		$errors[ 'feed' ] = 'blank';
}

?>

<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="UTF-8">
	<title>BBS投稿ページ</title>
	<link rel="stylesheet" type="text/css" href="../css/style.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script src="../js/jquery-3.1.1.js"></script>
</head>

<body>
	<header>
		<?php include ('../header/header.php'); ?>
	</header>
	<div class="formWrap">
		<h1><img src="img/newbbs.png"></h1>
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
				<form action="" method="POST">
					<input type="hidden" name="username" value="<?php echo $user['id']; ?>">
					<textarea type="text" name="body" placeholder="notice board"></textarea>
					<?php if(isset($errors['feed']) && $errors['feed'] == 'blank'): ?>
					<p class="red">投稿データを入力して下さい</p>
					<?php endif; ?>
					<div class="thbtn">
					<input id="submit" type="submit" value="投稿する">
					</div>
				</form>
			</section>
		</article>
		<div class="list_back">
		<a href="bbs_list.php">&#171;Go back</a>
		</div>
	</div>
		<?php include ('../footer/footer.php'); ?>
		<script type="text/javascript" src="../js/bbs_app.js"></script>
</body>
</html>