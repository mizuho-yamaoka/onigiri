<!doctype html>
<html>
<head>
	<meta charset="UTF-8">
	<title>cebufull</title>
	<link rel="stylesheet" type="text/css" href="style.css">
	<link rel="stylesheet" type="text/css" href="slick/slick.css">
	<link rel="stylesheet" type="text/css" href="slick/slick-theme.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
</head>

<body>

	<header>
		<div id="groval-navi">
			<div class="navi">
				<h1 class="logo"><img src="img/cebufull_logo.png"></h1>

				<!--pcOnly navi-->
				<ul class="navilist pcOnly">
					<li>
						<p><a href="#">ABOUT</a>
						</p>
					</li>
					<li>
						<p><a href="#">BBS</a>
						</p>
					</li>
					<li class="lilast">
						<p><a href="#">BLOG</a>
						</p>
					</li>
					<li class="login">
						<p><a href="#">LOGIN</a>
						</p>
					</li>
					<li class="newA">
						<p><a href="#">NEW ACCOUNT</a>
						</p>
					</li>
				</ul>
				<!--pcOnly navi-->

				<!--spOnly navi-->
				<div class="spnavi">
				<div id="overlay">
					<ul>
						<li><a href="#">ABOUT</a>
						</li>
						<li><a href="#">BBS</a>
						</li>
						<li><a href="#">BLOG</a>
						</li>
						<li><a href="#">LOGIN</a>
						</li>
						<li><a href="#">NEW ACCOUNT</a>
						</li>
					</ul>
				</div>
				<a class="menu-trigger" href="#"><span></span><span></span><span></span></a>
				</div>
				<!--spOnly navi-->
					

			</div>
		</div>
		<div class="headimg"><video src="img/sea.mp4" autoplay loop="auto"></video>
		</div>
	</header>

	<div class="wrap">
		<div class="aboutWrap">
			<div class="acWrap">
				<h2><img src="img/about.png" alt="cebufullについて"></h2>
				<div class="aboutTxet">
					<p class="ajp">
						このサイトはセブ留学生による、セブ留学生の為の情報交換サイトです。<br> セブに留学に来たあなたの情報で当サイトを育ててあげてください♪
					</p>
					<p class="aen">
						This site is for Cebu international students by international students in Cebu.<br> Please raise this site with your information came to study in Cebu♪
					</p>
				</div>
				<div class="howbtn">
					<P><a href="#">How to use<span><img src="img/arrow.png" alt="サイトの使い方"></span></a>
					</P>
				</div>
			</div>
		</div>
		<!--aboutWrap-->

		<div class="nowWrap">
			<div class="ncWrap">
				<h2><img src="img/now.png" alt="つぶやき"></h2>
				<iframe id="now" width="100%" height="200" src="now.php"></iframe>
			</div>
		</div>
		<!--nowWrap-->

		<div class="howToWrap">
			<div class="hcWrap">
				<div class="bgimg">
					<h2><img src="img/howtocebu.png" alt="howtocebu"></h2>
				</div>
				<div class="teWrap">
					<div class="howtoTxet">
						<p class="ajp">
							役に立ったり立たなかったり？！なコラム集。セブ生活をもっと知りたい方は必見です！
						</p>
						<p class="aen">
							Is it useful or not? ! Column collection. It is a must-see for those who want to know more about Cebu life!
						</p>
						<div class="howtobtn">
							<P><a href="#">How to use<span><img src="img/arrow.png" alt="サイトの使い方"></span></a>
							</P>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!--howToWrap-->

		<div class="bbsWrap">
			<div class="bcWrap">
				<h2><img src="img/morefun.png" alt="もっと楽しもう"></h2>
				<div class="slick_container pcOnly">
					<section class="regular slider">
						<div>
							<img src="http://placehold.it/350x300?text=1">
						</div>
						<div>
							<img src="http://placehold.it/350x300?text=2">
						</div>
						<div>
							<img src="http://placehold.it/350x300?text=3">
						</div>
						<div>
							<img src="http://placehold.it/350x300?text=4">
						</div>
						<div>
							<img src="http://placehold.it/350x300?text=5">
						</div>
						<div>
							<img src="http://placehold.it/350x300?text=6">
						</div>
					</section>
				</div>
				<div class="bbsbtn">
					<P><a href="#">BBS list<span><img src="img/arrow.png" alt="サイトの使い方"></span></a>
					</P>
				</div>
			</div>
		</div>
		<!--bbsWrap-->

		<div id="footer">
			<div class="footerWrap">
				<div class="flogo"><img src="img/flogo.png" alt="cebufull">
				</div>
				<div class="footerMenu">
					<ul class="fmenu1">
						<li>
							<p><a href="#"><span><img src="img/farrow.png"></span>About us</a>
							</p>
						</li>
						<li>
							<p><a href="#"><span><img src="img/sankaku.png"></span>How to use</a>
							</p>
						</li>
					</ul>
					<ul class="fmenu2">
						<li>
							<p><a href="#"><span><img src="img/farrow.png"></span>NOW</a>
							</p>
						</li>
						<li>
							<p><a href="#"><span><img src="img/farrow.png"></span>HOW TO CEBU</a>
							</p>
						</li>
						<li>
							<p><a href="#"><span><img src="img/farrow.png"></span>BBS</a>
							</p>
						</li>
					</ul>
				</div>
			</div>
		</div>


	</div>
	<!--wrap-->

	<script src="https://code.jquery.com/jquery-2.2.0.min.js" type="text/javascript"></script>
	<script src="slick/slick.js" type="text/javascript" charset="utf-8"></script>
	<script src="style.js" type="text/javascript" charset="utf-8"></script>

</body>
</html>