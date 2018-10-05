<?php
require('path.php');
?>

<!doctype html>
<html>
<head>
	<meta charset="UTF-8">
	<title>cebufull</title>
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<link rel="stylesheet" type="text/css" href="js/slick/slick.css">
	<link rel="stylesheet" type="text/css" href="js/slick/slick-theme.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
</head>

<body>

	<header>
		<?php include ('header/header.php'); ?>
	</header>
	</div>
	<div class="headimg"><video src="img/sea.mp4" autoplay loop="auto"></video>
	</div>
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
				<div class="slick_container pcOnlylist">
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
		<?php include ('footer/footer.php'); ?>
</body>
</html>