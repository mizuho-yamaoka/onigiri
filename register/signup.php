<?php
require( '../path.php' );
require('vendor/autoload.php');
date_default_timezone_set( 'Asia/Manila' ); 
//フィリピン時間に設定
session_start();
var_dump('hoge');
// use Cloudinary;
// use Cloudinary\Uploader;

// $account = parse_url(getenv('CLOUDINARY_URL'));

// \Cloudinary::config(array(
//     "cloud_name" => 'hpzkypnos',
//     "api_key" => '868377629318311',
//     "api_secret" => 'khzmmn9AGVgMOlAKsTQRgw8s69w'
// ));

// $ret = \Cloudinary\Uploader::upload("https://farm9.staticflickr.com/8748/16531734384_afdd2327e5_z.jpg");

// print_r($ret);

$name = '';
$email = '';
$school = '';
$gender = '';
$age = '';
$school = '';
$other = '';
// バリデーションに引っかかった項目を入れる
$errors = array();
//バリデーション
if ( !empty( $_POST ) ) {
	$name = $_POST[ 'name' ];
	$email = $_POST[ 'email' ];
	$password = $_POST[ 'password' ];
	$str_age = $_POST[ 'age' ];
	$age = ( int )$str_age;
	$school = $_POST[ 'school' ];
	$other = $_POST[ 'other' ];

	if ( isset( $_POST[ 'gender' ] ) ) {
		$str_gender = $_POST[ 'gender' ];
		$gender = ( int )$str_gender;
	}
	//ユーザー名の空チェック
	if ( $name == '' ) {
		$errors[ 'name' ] = 'blank';
	}

	//メールアドレスの空チェック
	if ( $email == '' ) {
		$errors[ 'email' ] = 'blank';
	}

	//パスワードの空チェック
	$count = strlen( $password ); //hogehogeとパスワードを入力した際、8が$countに代入される
	if ( $password == '' ) {
		$errors[ 'password' ] = 'blank';
	} elseif ( $count < 4 || 16 < $count ) {
		// ||演算子を使って4文字未満または16文字より多い場合にエラー配列にlengthを代入
		$errors[ 'password' ] = 'length';
	}

	//画像名を取得
	$file_name = $_FILES[ 'img_name' ][ 'name' ];
	if ( empty( $file_name ) ) {
		$errors[ 'img_name' ] = 'blank';
	} else {
		$file_type = substr( $file_name, -3 );
		echo '<br>';
		if ( $file_type != 'jpg' && $file_type != 'png' && $ext != 'gif' ) {
			$errors[ 'img_name' ] = 'type';
		}
	}

	//性別の空チェック
	if ( $gender == '' ) {
		$errors[ 'gender' ] = 'blank';
	}

	//年齢の空チェック
	if ( $age == '' ) {
		$errors[ 'age' ] = 'blank';
	}

	//語学学校チェック
	if ( $school == '' ) {
		$errors[ 'school' ] = 'blank';
	}

	//備考チェック
	if ( $other == '' ) {
		$errors[ 'other' ] = 'blank';
	}

	//エラーがなかったときの処理
	if ( empty( $errors ) ) {
		$date_str = date( 'YmdHis' );
		$submit_file_name = $date_str . $file_name;
		$cloudinary_name = explode($submit_file_name, '.');

		move_uploaded_file(
			$_FILES[ 'img_name' ][ 'tmp_name' ],
			'../user_profile_img/' . $submit_file_name );
		// \Cloudinary\Uploader::upload($cloudinary_name[0]);

		$_SESSION[ 'register' ] = $_POST;
		$_SESSION[ 'register' ][ 'img_name' ] = $submit_file_name;

		header( 'Location: check.php' );
		// exit();
	}
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="utf-8">
	<title>Team Project</title>
	<link rel="stylesheet" type="text/css" href="../css/style.css">
</head>

<body>
	<header>
		<?php include ('../header/header.php'); ?>
	</header>
	<div class="nAca">
		<article>
			<div class="coWrap">
				<div class="cotitle">
					<h1><img src="img/cebufull_logo.png"></h1>
					<p><img src="img/nac.png">
				</div>
				<section>
					</p>
					<form action="signup.php" method="POST" enctype="multipart/form-data">
						<div class="inputA">
							<ul>
								<li>
									<label for="name">ユーザー名(Username)</label>
									<input type="text" name="name" placeholder="username" value="<?php echo htmlspecialchars($name); ?>">
									<?php if(isset($errors['name']) && $errors['name'] == 'blank') : ?>
									<p class="caution">Please enter username</p>
									<?php endif; ?>
								</li>
								<li>
									<label for="email">メールアドレス(email)</label>
									<input type="email" name="email" placeholder="example@.com" value="<?php echo htmlspecialchars($email); ?>">
									<?php if(isset($errors['email']) && $errors['email'] == 'blank') : ?>
									<p class="caution">Please enter email</p>
									<?php endif; ?>
								</li>
								<li>
									<label for="password">パスワード(password)</label>
									<input type="password" name="password" placeholder="password">
									<?php if(isset($errors['password']) && $errors['password'] == 'blank'): ?>
									<span class="caution">Please Enter Password</span>
									<?php endif; ?>
								</li>
								<li>
									<?php if(isset($errors['password'])&& $errors['password'] == 'length'):?>
									<span class="caution">パスワードをは4〜16文字で入力して下さい。<s></s></span>
									<?php endif; ?>
								</li>
								<li>
									<label for="img_name">プロフィール画像(profile image)</label>
									<input type="file" name="img_name" accept="image/*">
									<?php if(isset($errors['img_name']) && $errors['img_name'] == 'blank'):?>
									<p>画像を選択して下さい(Pleae choose a your image picture)</p>
									<?php endif; ?>
									<?php if(isset($errors['img_name']) && $errors['img_name'] == 'type'):?>
									<p class="caution">拡張子が「jpg」「png」「gif」の画像を選択してください(Please select an image with the extension "jpg" "png" "gif")</p>
									<?php endif; ?>
								</li>
								<li>
									<div>
										<img src="img/male.png"><span>Male</span>
										<input type="radio" name="gender" value="1">
									</div>
									<div>
										<img src="img/female.png"><span>Female</span>
										<input type="radio" name="gender" value="2">
									</div>
									<div class="nc caution">
										Do not register<input type="radio" name="gender" value="3">
									</div>
									
									<?php if(isset($errors['gender']) && $errors['gender'] == 'blank'): ?>
									<p class="caution">Please select your gender</p>
									<?php endif; ?>
								</li>
								<li>
									<label for="age">年齢(Age)</label>
									<input type="text" name="age" placeholder="age" value="<?php echo $age; ?>">
									
									<?php if(isset($errors['age']) && $errors['age'] == 'blank') : ?>
									<p class="caution">Please enter your age</p>
									<?php endif; ?>
								</li>
								<li>
									<label for="school">語学学校(School)</label>
									<input type="text" name="school" placeholder="QQ English" value="<?php echo htmlspecialchars($school);?>">
									<?php if(isset($errors['school']) && $errors['school'] == 'blank') : ?>
									<p class="caution">Please enter your school</p>
									<?php endif; ?>
								</li>
								<li>
									<label for="other">追記事項(Extra profile)</label>
									<input type="text" name="other" value="<?php echo htmlspecialchars($other);?>">
									<?php if(isset($errors['other']) && $errors['other'] == 'blank') : ?>
									<p class="caution">Please enter your other</p>
									<?php endif; ?>
								</li>
							</ul>
						</div>
						<div class="com_b">
							<input type="submit" value="確認(submit)">
						</div>
					</form>
				</section>
			</div>
		</article>
	</div>
			<?php include ('../footer/footer.php'); ?>

</body>
</html>
