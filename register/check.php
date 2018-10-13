<?php
require( '../path.php' );
session_start();
require( '../dbconnect.php' );

if ( !isset( $_SESSION[ 'register' ] ) ) {
	header( 'Location: signup.php' );
	exit();
}
// session_destroy();
$name = $_SESSION[ 'register' ][ 'name' ];
$email = $_SESSION[ 'register' ][ 'email' ];
$password = $_SESSION[ 'register' ][ 'password' ];
$img_name = $_SESSION[ 'register' ][ 'img_name' ];
$gender = $_SESSION[ 'register' ][ 'gender' ];
$age = $_SESSION[ 'register' ][ 'age' ];
$school = $_SESSION[ 'register' ][ 'school' ];
$other = $_SESSION[ 'register' ][ 'other' ];

//登録ボタンが押された時のみ処理するif文
if ( !empty( $_POST ) ) {
	// パスワードをハッシュ化

	$hash_password = password_hash( $password, PASSWORD_DEFAULT );

	$sql = 'INSERT INTO `users` SET `name` = ?, `email` = ?, `password` = ?, `img_name` = ?, `gender` =?, `age` = ?, `school` = ?, `other` = ?, `created` =NOW()';
	$data = array( $name, $email, $hash_password, $img_name, $gender, $age, $school, $other );
	$stmt = $dbh->prepare( $sql );
	$stmt->execute( $data );

	unset( $_SESSION[ 'register' ] );
	header( 'Location: thanks.php' );
	exit();
}

// 下記出力結果
// → $2y$10$XdbJN1gMyCAoB77oDO2.fOZ1PcnPa2x105v/fkJlJ3raC3aR2LsCG

?>

<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="utf-8">
	<title>CEBUFULL</title>
	<link rel="stylesheet" type="text/css" href="../css/style.css">
</head>

<body>
	<header>
		<?php include ('../header/header.php'); ?>
	</header>
	<div class="nAcac">
		<article>
			<div class="coWrap">
				<div class="cotitle">
					<h1><img src="img/cebufull_logo.png"></h1>
					<p><img src="img/check.png">
					</p>
				</div>
				<div class="coco">
					<section class="l_user">
						<div class="writer">
							<img src="../user_profile_img/<?php echo $img_name ;?>" width="60">
						</div>
					</section>
					<section class="bl_input">
						<ul>
							<li>
								<p><span>ユーザー名(Username)</span>
									<?php echo htmlspecialchars($name); ?>
								</p>
							</li>
							<li>
								<p><span>メールアドレス(Email)</span>
									<?php echo htmlspecialchars($email); ?>
								</p>
							</li>
							<li>
								<p><span>パスワード(Password)</span>●●●●●●●</p>
							</li>
							<li>
								<p><span>性別(Gender)</span>
									<?php echo htmlspecialchars($gender); ?>
								</p>
							</li>
							<li>
								<p><span>年齢(Age)</span>
									<?php echo htmlspecialchars($age); ?>
								</p>
							</li>
							<li>
								<p><span>語学学校(School)</span>
									<?php echo htmlspecialchars($school); ?>
								</p>
							</li>
							<li>
								<p><span>備考(Other)</span>
									<?php echo htmlspecialchars($other); ?>
								</p>
							</li>
						</ul>
					</section>
				</div>
		</article>
			<article class="nbbtn">
		<form method="POST" action="">
			<a href="signup.php?action=rewrite" class="btn btn-default"><i class="fas fa-angle-double-left"></i>修正(back)</a>
			<input type="hidden" name="action" value="submit">
			<input type="submit" class="btn btn-primary" value="登録(User registration)"><i class="fas fa-angle-double-right"></i>
		</form>
			</article>
		</div>
	</div>
	<?php include ('../footer/footer.php'); ?>
</body>
</html>