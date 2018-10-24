<?php
require( 'path.php' );
session_start();
require_once( 'dbconnect.php' );
require_once( 'function.php' );

$signin_user_id = '';
if ( isset( $_SESSION[ 'register' ][ 'id' ] ) ) {
	$signin_user_id = $_SESSION[ 'register' ][ 'id' ];

	//SELECTで現在サインインしているユーザーの情報をusersテーブルから読み込む
	$sql = 'SELECT `id`, `name`, `img_name` FROM `users` WHERE `id` = ?';
	$data = [ $signin_user_id ];
	$stmt = $dbh->prepare( $sql );
	$stmt->execute( $data );

	// フェッチする
	$user = $stmt->fetch( PDO::FETCH_ASSOC );
	$img_name = $user[ 'img_name' ];
	$name = $user[ 'name' ];
}
$sql = 'SELECT `p`.*, `u`.`name` FROM `posts` AS `p` LEFT JOIN `users` AS `u` ON `p`. `user_id` = `u`. `id` ORDER BY `p`.`created` DESC LIMIT 6 ';
$stmt = $dbh->prepare( $sql );
$stmt->execute();


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
?>

<!doctype html>
<html>
<head>
	<meta charset="UTF-8">
	<title>cebufull</title>
	<!--共通-->
	<link rel="stylesheet" type="text/css" href="css/style.css" media="screen">
	<!--indexOnly-->
	<link rel="stylesheet" type="text/css" href="js/slick/slick.css">
	<link rel="stylesheet" type="text/css" href="js/slick/slick-theme.css">
	<!--font-->
	<link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
	<!--共通-->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
</head>

<body>

	<header>
		<div id="groval-navi">
			<div class="navi">
				<h1 class="logo"><a href="/Lechon/index.php"><?php logoimg(); ?></a></h1>
				<!--pcOnly navi-->
				<div class="navb pcOnly">
					<ul class="navilist pcOnly">
						<li>
							<p><a href="#aboutWrap">ABOUT</a>
							</p>
						</li>
						<li>
							<p><a href="#nowWrap">NOW</a>
							</p>
						</li>
						<li>
							<p><a href="#bbsWrap">BBS</a>
							</p>
						</li>
						<li>
							<p><a href="#howToWrap">BLOG</a>
							</p>
						</li>
					</ul>
					<!--ログイン前-->
					<div class="chda">
						<?php if(!isset($_SESSION['register']['id'])) :?>
						<div class="login">
							<p><a href="/Lechon/signin.php">LOGIN</a>
							</p>
						</div>
						<div class="newA">
							<p><a href="/Lechon/register/signup.php">NEW ACCOUNT</a>
							</p>
						</div>
						<?php endif; ?>
					</div>
					<!--ログイン後-->
					<div class="chda2">
						<?php if(isset($_SESSION['register']['id'])): ?>
						<div class="logout">
							<p><a href="/Lechon/signout.php">LOGOUT</a>
							</p>
						</div>
						<div class="user_img">
							<p><img src="user_profile_img/<?php echo $img_name ?>" alt="" width="60px">
								</a>
							</p>
						</div>
						<div class="user_name">
							<p>
								<a href="/Lechon/mypage/mypage.php">
									<?php echo $name ?>
								</a>
							</p>
						</div>
						<?php endif ;?>
					</div>
				</div>
				<!--pcOnly navi-->

				<!--spOnly navi-->
				<div class="spnavi">
					<div id="overlay">
						<ul>
							<li><a href="blog/blog_list.php">BLOG</a>
							</li>
							<li><a href="bbs/bbs_list.php">BBS</a>
							</li>
						</ul>
						<ul>
							<?php if(!isset($_SESSION['register']['id'])): ?>
							<li><a href="/Lechon/signin.php">LOGIN</a>
							</li>
							<li><a href="/Lechon/register/signup.php">NEW ACCOUNT</a>
							</li>
							<?php endif ;?>
						</ul>
						<ul>
							<?php if(isset($_SESSION['register']['id'])): ?>
							<li><a href="/Lechon/signout.php">LOGOUT</a>
							</li>
							<li><a href="/Lechon/mypage/mypage.php">MY PAGE</a>
							</li>
							<?php endif ;?>
						</ul>
					</div>
					<a class="menu-trigger" href="#"><span></span><span></span><span></span></a>
				</div>
				<!--spOnly navi-->

			</div>
	</header>
	</div>
	<div class="headimg"><video src="img/sea.mp4" autoplay loop="auto"></video>
	</div>
	<article class="wrap">
		<section id="aboutWrap">
			<div class="acWrap">
				<h1><img src="img/about.png" alt="cebufullについて"></h1>
				<div class="aboutTxet">
					<p class="ajp">
						このサイトはセブ留学生による、セブ留学生の為の情報交換サイトです。<br> セブに留学に来たあなたの情報で当サイトを育ててあげてください♪
					</p>
					<p class="aen">
						This is an information exchange platform site, by international students in Cebu, for international students in Cebu.<br> Please share the infomations about Cebu to this site ♪
					</p>
				</div>
			</div>
		</section>
		</div>
		<!--aboutWrap-->

		<section id="nowWrap">
			<div class="ncWrap">
				<h1><img src="img/now.png" alt="つぶやき"></h1>
				<iframe id="now" width="100%" height="450" src="now/now.php" scrolling="no"></iframe>
			</div>
		</section>
		<!--nowWrap-->

		<section id="bbsWrap">
			<div class="hcWrap">
				<div class="bgimg">
					<h1><img src="img/morefun.png" alt="もっと楽しもう"></h1>
				</div>
				<div class="teWrap">
					<div class="howtoTxet">
						<p class="ajp">
							役に立ったり立たなかったり？！なコラム集。セブ生活をもっと知りたい方は必見です！
						</p>
						<p class="aen">
							These blogs helping you on and off !? If you want to know the life of Cebu, this blog is must-see!
						</p>
						<div class="howtobtn">
							<P><a href="bbs/bbs_list.php">BBS list<span><img src="img/arrow.png" alt="サイトの使い方"></span></a>
							</P>
						</div>
					</div>
				</div>
			</div>
		</section>
		<!--howToWrap-->

		<section id="howToWrap">
			<div class="bcWrap">
				<h1><img src="img/howtocebu.png" alt="howtocebu"></h1>
				<div class="slick_container pcOnlylist">
					<section class="regular slider">
						<?php foreach ($posts as $post):?>
						<div class="blw">
						<div class="inblaw">
							<div class="blog_thum">
								<!-- <img src="img/ジンベイザメ横から.jpg"> -->
								<img src="<?php echo catch_that_image($post['post']); ?>">
							</div>
								<div class="bwi">
							<form action="blog/blog.php" method="POST">
								<!-- 1件づつ処理 -->
									<ul>
										<li><?php echo $post['name'] ?></li>
										<li class="time"><?php echo $post['created'] ?></li>
									</ul>
								<div class="title">
									<?php echo $post['title'] ?>
								</div>
								<div class="body">
									<?php echo $post['post'] ?>
								</div>
								<div class="ebtn">
								<input type="hidden" name="post_id" value="<?php echo $post['id'] ?>">
								<input type="submit" name="submit" value="Read more">
								</div>
							</form>
						</div>
						</div>
							</div>
						<?php endforeach; ?>
					</section>
				<div class="bbsbtn">
					<P><a href="blog/blog_list.php">Blog list<span><img src="img/arrow.png" alt="サイトの使い方"></span></a>
					</P>
				</div>
			</div>
		</section>
	</article>
	<!--bbsWrap-->
	<div id="footer">
		<div class="footerWrap">
			<div class="flogo"><img src="img/flogo.png" alt="cebufull">
			</div>
			<div class="footerMenu">
				<ul class="fmenu1">
					<li>
						<p><span><img src="img/farrow.png"></span>About us
						</p>
					</li>
					<li>
						<p><a href="#aboutWrap"><span><img src="img/sankaku.png"></span>How to use</a>
						</p>
					</li>
				</ul>
				<ul class="fmenu2">
					<li>
						<p><a href="#nowWrap"><span><img src="img/farrow.png"></span>NOW</a>
						</p>
					</li>
					<li>
						<p><a href="blog/blog_list.php"><span><img src="img/farrow.png"></span>HOW TO ENJOY CEBU</a>
						</p>
					</li>
					<li>
						<p><a href="bbs/bbs_list.php"><span><img src="img/farrow.png"></span>BBS</a>
						</p>
					</li>
				</ul>
			</div>
		</div>
	</div>
	</div>
	<!--wrap-->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script src="https://code.jquery.com/jquery-2.2.0.min.js" type="text/javascript"></script>
	<!--＊-->
	<script src="js/slick/slick.js" type="text/javascript" charset="utf-8"></script>
	<!--indexOnly-->
	<script src="js/style.js" type="text/javascript" charset="utf-8"></script>
	<!--＊-->
</body>
</html>