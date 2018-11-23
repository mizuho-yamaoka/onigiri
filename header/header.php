<?php
// session_start();
// require_once( '../dbconnect.php' );

$signin_user_id = '';
if(isset($_SESSION['register']['id'])){
	
$signin_user_id = $_SESSION[ 'register' ][ 'id' ];

//SELECTで現在サインインしているユーザーの情報をusersテーブルから読み込む
$sql = 'SELECT `id`, `name`, `img_name` FROM `users` WHERE `id` = ?';
$data = [ $signin_user_id ];
$stmt = $dbh->prepare( $sql );
$stmt->execute( $data );

// フェッチする
$user = $stmt->fetch( PDO::FETCH_ASSOC );

$img_name = $user['img_name'];
$name = $user['name'];

}
?>

		<div id="groval-navi">
			<div class="navi">
				<h1 class="logo"><a href="/cebufull/Lechon/index.php"><?php logoimg(); ?></a></h1>

				<!--pcOnly navi-->
				<div class="navb pcOnly">
				<ul class="navilist">
					<li>
						<p><a href="/cebufull/Lechon/blog/blog_list.php">BLOG</a>
						</p>
					</li>
					<li>
						<p><a href="/cebufull/Lechon/bbs/bbs_list.php">BBS</a>
						</p>
					</li>
				</ul>

				<div class="chda">
					<?php if(!isset($_SESSION['register']['id'])) :?>
						<div class="login">
							<p><a href="/cebufull/Lechon/signin.php">LOGIN</a>
							</p>
						</div>
						<div class="newA">
							<p><a href="/cebufull/Lechon/register/signup.php">NEW ACCOUNT</a>
							</p>
						</div>
					<?php endif; ?>
				</div>

				<div class="chda2">
					
					<?php if(isset($_SESSION['register']['id'])): ?>
						<div class="logout">
							<p><a href="/cebufull/Lechon/signout.php">logout</a></p>
						</div>
						<div class="user_img">
							<p><img src="../user_profile_img/<?php echo $img_name ?>" alt="" width="60px"></a></p>
						</div>
						<div class="user_name">
							<p><a href="/cebufull/Lechon/mypage/mypage.php"><?php echo $name ?></a></p>
						</div>
					<?php endif ;?>
				</div>
</div>
				<!--pcOnly navi-->

				<!--spOnly navi-->
				<div class="spnavi">
				<div id="overlay">
					<ul>
						<li><a href="/cebufull/Lechon/blog/blog_list.php">BLOG</a>
						</li>
						<li><a href="/cebufull/Lechon/bbs/bbs_list.php">BBS</a>
						</li>
					<div>
						<?php if(!isset($_SESSION['register']['id'])): ?>
							<li><a href="/cebufull/Lechon/signin.php">LOGIN</a>
							</li>
							<li><a href="/cebufull/Lechon/register/signup.php">NEW ACCOUNT</a>
							</li>
						<?php endif ;?>
					</div>
					<div>
						<?php if(isset($_SESSION['register']['id'])): ?>

							<li><a href="/cebufull/Lechon/signout.php">LOGOUT</a>
							</li>
							<li><a href="/cebufull/Lechon/mypage/mypage.php">MY PAGE</a>
							</li>
						<?php endif ;?>
					</div>
					</ul>
				</div>
				<a class="menu-trigger" href="#"><span></span><span></span><span></span></a>
				</div>
				<!--spOnly navi-->
					
			</div>

