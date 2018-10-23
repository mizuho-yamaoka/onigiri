<?php
require( '../path.php' );
// session_start();
require_once( '../dbconnect.php' );

// ログイン不要のページなのでセッションの存在の確認は不要
// if (!isset($_SESSION['register']['id'])) { //①:セッションに保存する一つ目にカラム名をhogehogeに入れる
// }

// $signin_user_id = $_SESSION[ 'register' ][ 'id' ]; //②:①同様

// $sql = 'SELECT `id`,`name`,`img_name` FROM `users` WHERE `id`=?'; //③:insert,select時に必要なカラム名を指定＊変更があれば
// $data = [ $signin_user_id ];
// $stmt = $dbh->prepare( $sql );
// $stmt->execute( $data );

// $user = $stmt->fetch( PDO::FETCH_ASSOC );

// $user_img_name = $user[ 'img_name' ];

$murmur = '';
$errors = [];

// バリデーション
if ( !empty( $_POST ) ) {
	$murmur = $_POST[ 'murmur' ];
	if ( $murmur == '' ) {
		$errors[ 'murmur' ] = 'blank';
	}
}

// 投稿機能
if ( !empty( $_POST[ 'murmur' ] ) ) {
	$murmur = $_POST[ 'murmur' ];
	$nickname = $_POST[ 'nickname' ];

	$sql = 'INSERT INTO `murmurs` SET `nickname` = ?,`murmur`=?,`created`=NOW()';
	$data = [ $nickname, $murmur ];
	$stmt = $dbh->prepare( $sql );
	$stmt->execute( $data );

	header( 'Location:now.php' );
	exit();
}

// テーブル名変更とカラム名の追加（ユーザーイメージ）をしたのでSQL文を変更
$sql = "SELECT * FROM murmurs WHERE 1 ORDER BY created DESC";
// $sql='SELECT `f`.*,`u`.`name`,`u`.`img_name` FROM `murmurs` AS `f` LEFT JOIN `users` AS `u` ON `f`.`user_id`=`u`.`id` ORDER BY `f`.`created` DESC';//④:③同様
$stmt = $dbh->prepare( $sql );
$stmt->execute();

$murmur = array();
while ( true ) {
	$record = $stmt->fetch( PDO::FETCH_ASSOC );

	if ( $record == false ) {
		break;
	}
	$murmurs[] = $record;
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
	<title></title>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="assets/css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="../css/style.css">
	<link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
</head>

<body class="now">
	<div class="nowWrap">
		<article class="murti">
			<?php foreach($murmurs as $murmur):?>
			<section class="mur">
				<ul>
					<li><?php echo $murmur['nickname'] ?></li>
					<li><?php echo $murmur['created'] ?></li>
				</ul>
				<div>
					<?php echo $murmur['murmur'] ?>
				</div>
			</section>
			<?php endforeach;?>
		</article>
		<div class="murform">
			<div class="mpos">
				<form action="" method="POST">
					<div class="nn">
						<input type="text" name="nickname" placeholder="Nickname" >
					</div>
					<div class="mp">
						<input type="text" name="murmur" placeholder="Hello!!"><br>
						<?php if (isset($errors['murmur']) && $errors['murmur'] == 'blank'):?>
						<p class="red">内容を入力してください<br>
						Plese write something.</p>
						<?php endif; ?>
					</div>
					<input type="submit" value="POST">
				</form>
			</div>
		</div>
	</div>
</body>
</html>