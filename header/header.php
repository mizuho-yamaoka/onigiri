<?php
// session_start();
require_once( '../dbconnect.php' );

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
// echo '<pre>';
// var_dump();
// echo '</pre>';

}
?>

		<div id="groval-navi">
			<div class="navi">
				<h1 class="logo"><a href="/Lechon/index.php"><?php logoimg(); ?></a></h1>

				<!--pcOnly navi-->
				<ul class="navilist pcOnly">
					<li>
						<p><a href="#aboutWrap">ABOUT</a>
						</p>
					</li>
					<li>
						<p><a href="/Lechon/bbs/bbs_list.php">NOW</a>
						</p>
					</li>
					<li>
						<p><a href="/Lechon/blog/blog_list.php">BLOG</a>
						</p>
					</li>
					<li class="lilast">
						<p><a href="/Lechon/bbs/bbs_list.php">BBS</a>
						</p>
					</li>
				</ul>
				<div class="chda">
					<div class="login">
						<p><a href="/Lechon/signin.php">LOGIN</a>
						</p>
					</div>
					<div class="newA">
						<p><a href="/Lechon/register/signup.php">NEW ACCOUNT</a>
						</p>
					</div>
				</div>
				<div class="chda_2">
					<p><img src="../user_profile_img/<?php echo $img_name ?>" alt="" width="60px"></a></p>
				</div>
				<div class="chda_2">
					<p><a href="/Lechon/mypage/mypage.php"><?php echo $name ?></a></p>
				</div>
				<div class="chda_2">
					<p><a href="/Lechon/signout.php">sign out</a></p>
				</div>


				<!--pcOnly navi-->

				<!--spOnly navi-->
				<div class="spnavi">
				<div id="overlay">
					<ul>
						<li><a href="#">ABOUT</a>
						</li>
						<li><a href="../blog_list.php">NOW</a>
						</li>
						<li><a href="/Lechon/blog/blog_list.php">BLOG</a>
						</li>
						<li><a href="/Lechon/bbs/bbs_list.php">BBS</a>
						</li>
						<li><a href="/Lechon/signin.php">LOGIN</a>
						</li>
						<li><a href="/Lechon/register/signup.php">NEW ACCOUNT</a>
						</li>
					</ul>
				</div>
				<a class="menu-trigger" href="#"><span></span><span></span><span></span></a>
				</div>
				<!--spOnly navi-->
					
			</div>

