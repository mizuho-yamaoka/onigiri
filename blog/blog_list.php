<?php
session_start(); 
require( '../path.php' );
require_once( '../dbconnect.php' );
require_once('../bbs/function.php');

// ６記事で１ページの出力
// 定数定義

$page = 1;
$start = 0;
$last_page = '';
$word_search = '';

const CONTENT_PER_PAGE = 8;
if ( isset( $_GET[ 'page' ] ) ) {
	// -1などの不正な数字対策
	$page = $_GET[ 'page' ];
	$page = max( $page, 1 );


	// ヒットしたレコード数を取得するSQL文
	$sql_count = "SELECT COUNT(*) AS `cnt` FROM `posts`";
	$stmt_count = $dbh->prepare( $sql_count );
	$stmt_count->execute();

	$record_cnt = $stmt_count->fetch( PDO::FETCH_ASSOC );

	// 取得したページ数を１ページあたりに表示する件数で割って何ページか最後になるのか取得
	$last_page = ceil( $record_cnt[ 'cnt' ] / CONTENT_PER_PAGE );
	// 最後のページより大きい値を渡された場合、適切な値に置き換える
	$page = min( $page, $last_page );
	$start = ( $page - 1 ) * CONTENT_PER_PAGE;
}

// カテゴリー検索
if ( isset( $_GET[ 'category' ] ) ) {

	$category_number = $_GET[ 'category' ];

	$sql = 'SELECT `p`.*, `u`.`name` FROM `posts` AS `p` LEFT JOIN `users` AS `u` ON `p`. `user_id` = `u`. `id` WHERE category_id = ? ORDER BY `p`.`created` DESC LIMIT ' . CONTENT_PER_PAGE . ' OFFSET ' . $start;
	$data = [ $category_number ];
	$stmt = $dbh->prepare( $sql );
	$stmt->execute( $data );
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

	// ワード検索機能
} elseif ( isset( $_GET[ 'wordsearch' ] ) ) {

	// 検索欄に入れられたワードを変数に代入
	$word_search = htmlspecialchars( $_GET[ 'wordsearch' ] );
	// ブログのタイトルとポスト（本記事）内のワード検索
	// LIKE"%' . $変数 . '%"  =>>> $変数が含まれているもの
	// WHERE句内 条件式A OR 条件式B =>>> AまたはBのとき

	$sql = 'SELECT p.*, u.name FROM posts AS p LEFT JOIN users AS u ON p. user_id = u. id WHERE post LIKE "%"?"%" OR title LIKE "%"?"%"ORDER BY p.created DESC LIMIT ' . CONTENT_PER_PAGE . ' OFFSET ' . $start;
	$data = [$word_search,$word_search];
	$stmt = $dbh->prepare( $sql );
	$stmt->execute( $data );

	// ポストに入れる配列
	$posts = array();
	// レコードがなくなるまで取得処理
	while ( true ) {
		// フェッチ
		$record = $stmt->fetch( PDO::FETCH_ASSOC );
		// レコードがなくなったら処理を抜ける
		if ( $record == false ) {
			break;
		}
		// レコードがあれば追加
		$posts[] = $record;
	}


	// 全記事表示
} else {
	$sql = 'SELECT `p`.*, `u`.`name` FROM `posts` AS `p` LEFT JOIN `users` AS `u` ON `p`. `user_id` = `u`. `id` ORDER BY `p`.`created` DESC LIMIT ' . CONTENT_PER_PAGE . ' OFFSET ' . $start;
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
}

// echo '<pre>';
// var_dump($posts);
// echo '</pre>';

	// $top_img = preg_match('(<img scr=)', $posts['post']);
	// echo $top_img;
?>

<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="UTF-8">
	<title>ブログ一覧</title>
	<link rel="stylesheet" type="text/css" href="../css/style.css" media="screen">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
</head>

<body>
	<header>
		<?php include ('../header/header.php'); ?>
	</header>
	<div class="topimg"></div>
	<div class="wrap">
		<div class="bloglistWrap">
			<div class="blcWrap">
				<div class="psbar">
					<!-- 検索ボックス -->
					<div class="search">
						<form method="GET" action="blog_list.php">
							<!--						<label for="wordsearch">フリーワード検索</label><br>-->
							<!-- テキストボックス -->
							<!-- value内は検索後検索したワードを表示 -->
							<input type="text" id="wordsearch" name="wordsearch" value="<?php echo $word_search; ?>">
							<!-- サーチボタン -->
							<input type="submit" name="submit" value="search"><br>
						</form>
					</div>
					<div class="bpost"><a href="post.php"><img src="img/writebtn.png"></a>
					</div>
				</div>
				<!-- カテゴリボタン -->
				<div>
					<form action="blog_list.php" method="GET">
						<ul class="ctbtn">
							<li>
								<div class="cteg1"><button type='submit' name='category' value="1"><img src="img/eat.jpg" alt="eat"></button>
								</div>
							</li>
							<li>
								<div class="cteg2"><button type='submit' name='category' value='2'><img src="img/activityb.jpg" alt="activity"></button>
								</div>
							</li>
							<li>
								<div class="cteg3"><button type='submit' name='category' value='3'><img src="img/life.jpg" alt="life"></button>
								</div>
							</li>
							<li>
								<div class="cteg4"><button type='submit' name='category' value='4'><img src="img/other.jpg" alt="other"></button>
								</div>
							</li>
						</ul>
					</form>
					<!-- 記事の出力 -->
				</div>
				<div>
					<div class="blw">
						<?php foreach ($posts as $post):?>
						<div class="blaw">
							<div class="blog_thum">
								<!-- <img src="img/ジンベイザメ横から.jpg"> -->
								<img src="<?php echo catch_that_image($post['post']); ?>" alt="">
							</div>
								<div class="bwi">
							<form action="blog.php" method="POST">
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
						<?php endforeach; ?>

					</div>
					<div class="ttp">
						<ul>
							<!-- GET送信のパラメータ
        URL?キー = 値
        URL?キー１ = 値１＆キー２= 値２ -->
							<!-- 最初のページではNEWERは押せない -->
							<li>
								<?php if($page == 1): ?>
								<a>Newer</a>
								<?php else: ?>
								<!-- それ以外の場合 -->
								<a href="blog_list.php?page=<?php echo $page -1; ?>">Newer</a>
								<?php endif; ?>
							</li>
							<!-- 最後のページではOlderは押せない -->
							<li>
								<?php if ($page == $last_page):?>
								<a>Older</a>
								<!-- それ以外の場合 -->
								<?php else: ?>
								<a href="blog_list.php?page=<?php echo $page +1; ?>">Older</a>
								<?php endif; ?>
							</li>
						</ul>
					</div>
				</div>
			</div>
			<!--blcWrap-->
		</div>
		<!--bloglistWrap-->
		<?php include ('../footer/footer.php'); ?>
</body>
</html>