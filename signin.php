<?php
require( 'path.php' );
// サインイン処理
session_start();
require_once( 'dbconnect.php' );

$errors = [];
$email = '';

// サインインボタンが押されたら
// $_POSTが空でなければ

if ( !empty( $_POST ) ) {
	$email = $_POST[ 'email' ];
	$password = $_POST[ 'password' ];

	// データベースとの照合
	// 入力されたメールアドレスとパスワードの組み合わせがusersテーブルに存在するか
	//バリデーション（emailとpasswordの入力空チェック）
	if ( $email != '' && $password != '' ) {
		// $errors['signin'] = 'blank';
		// SELECT文を使ってレコードを読み込む
		// 一致するデータがあるかどうか（存在）するかどうか
		// ①SQL文の文字をセットする
		$sql = 'SELECT * FROM `users` WHERE `email` = ?';
		// ②SQL文に含みたいデータを配列で用意する(タプル処理)
		$data = [ $email ];
		// ③SQL文の文字をprepare()にセットする
		$stmt = $dbh->prepare( $sql );
		// ④実行する
		$stmt->execute( $data );

		// 使えない→使えるデータに変換したい
		// フェッチする　fetch()
		// object型→Array型に変換する処理
		$record = $stmt->fetch( PDO::FETCH_ASSOC );
		// echo '<pre>';
		// var_dump ($record);
		// echo '</pre>';
		// 登録されたメールアドレスかチェック
		if ( $record == false ) {
			$errors[ 'signin' ] = 'failed';
		}
		// パスワードが一致するかチェック
		// $record['password']はDBから取ってきたパスワード
		if ( password_verify( $password, $record[ 'password' ] ) ) {
			// 認証成功
			// サインインするユーザーのIDをセッションに保存
			$_SESSION[ 'register' ][ 'id' ] = $record[ 'id' ];
			header( 'Location: index.php' );
		} else {
			// 認証失敗
			$errors[ 'signin' ] = 'failed';
		}
	} else {
		$errors[ 'signin' ] = 'blank';
	}
}

?>
<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="utf-8">
	<title>サインイン</title>
	<link rel="stylesheet" type="text/css" href="css/style.css">
</head>

<body>
	<header>
		<?php include ('header/header.php'); ?>
	</header>
	<div class="loginWrap">
		<div class="lcWrap">
			<article>
				<section>
					<h1><img src="img/signin.png" alt="サインイン"></h1>
					<form method="POST" action="" enctype="multipart/form-data">
						<div class="form-group">
							<p class="email">メールアドレス(Email)</p>
							<input type="email" name="email" class="form-control" id="email" placeholder="example@gmail.com" value="<?php echo $email ?>">
						</div>
						<div class="form-group">
							<p class="password">パスワード(Password)</p>
							<input type="password" name="password" class="form-control" id="password" placeholder="4 ~ 16 letters and numbers">
							<?php if(isset($errors['signin']) && $errors['signin'] == 'blank'): ?>
							<p class="red"> メールアドレスとパスワードを入力してください(Plese enter correct e-mail adress and password.)</p>
							<?php endif; ?><br>
							<?php if(isset($errors['signin']) && $errors['signin'] == 'failed'):?>
							<span class="red">サインインに失敗しました(Sign in was failed.)</span>
							<?php endif; ?>
						</div>
						<input type="submit" class="btn btn-info" value="SIGN IN">
					</form>
				</section>
			</article>
		</div>
	</div>
	<?php include ('footer/footer.php'); ?>
</body>
</html>