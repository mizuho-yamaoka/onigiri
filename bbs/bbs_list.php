<?php
require( '../path.php' );
session_start();
require_once( '../dbconnect.php' );
// ６記事で１ページの出力
// 定数定義
$page = 1;
$start = 0;
$last_page = '';
$word_search = '';
const CONTENT_PER_PAGE = 6;
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


// ワード検索機能
if ( isset( $_GET[ 'wordsearch' ] ) ) {

	// 検索欄に入れられたワードを変数に代入
	$word_search = htmlspecialchars( $_GET[ 'wordsearch' ] );
	// ブログのタイトルとポスト（本記事）内のワード検索
	// LIKE"%' . $変数 . '%"  =>>> $変数が含まれているもの
	// WHERE句内 条件式A OR 条件式B =>>> AまたはBのとき

	$sql = 'SELECT f.*, u.name FROM feeds AS f LEFT JOIN users AS u ON f. user_id = u. id WHERE feed LIKE "%"?"%" ORDER BY f.created DESC LIMIT ' . CONTENT_PER_PAGE . ' OFFSET ' . $start;

	$data = [ $word_search ];
	$stmt = $dbh->prepare( $sql );
	$stmt->execute( $data );

	// ポストに入れる配列
	$feeds = array();
	// レコードがなくなるまで取得処理
	while ( true ) {
		// フェッチ
		$record = $stmt->fetch( PDO::FETCH_ASSOC );
		// レコードがなくなったら処理を抜ける
		if ( $record == false ) {
			break;
		}
		// レコードがあれば追加
		$feeds[] = $record;
	}

	// 全記事表示
} else {
	$sql = 'SELECT `f`.*, `u`.`name` FROM `feeds` AS `f` LEFT JOIN `users` AS `u` ON `f`. `user_id` = `u`. `id` ORDER BY `f`.`created` DESC LIMIT ' . CONTENT_PER_PAGE . ' OFFSET ' . $start;
	$stmt = $dbh->prepare( $sql );
	$stmt->execute();

	// ポストを入れる配列
	$feeds = array();
	// レコードがなくなるまで取得処理
	while ( true ) {
		// 1件ずつフェッチ
		$record = $stmt->fetch( PDO::FETCH_ASSOC );
		// レコードがなければ処理を抜ける
		if ( $record == false ) {
			break;
		}
		// レコードがあれば追加
		$feeds[] = $record;
	}
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="UTF-8">
	<title>BBS一覧</title>
	<link rel="stylesheet" type="text/css" href="../css/style.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
</head>

<body>
	<header>
		<?php include ('../header/header.php'); ?>
	</header>
	<div class="topimg_b"></div>
	<div class="wrap">
		<div class="bbslistWrap">
			<div class="bbsWrap">
				<div class="htbox">
					<img src="img/mofun.png">
					<img src="img/tofun.png">
				</div>
				<div class="psbar">
					<!-- 検索ボックス -->
					<div class="search">
						<form method="GET" action="bbs_list.php">
							<!-- テキストボックス -->
							<!-- value内は検索後検索したワードを表示 -->
							<input type="text" id="wordsearch" name="wordsearch" value="<?php echo $word_search; ?>"><br>
							<!-- サーチボタン -->
							<input type="submit" name="submit" value="search"><br>
						</form>
					</div>
					<div class="bpost"><a href="feed.php"><img src="img/writebtn.png"></a>
					</div>
				</div>
				<!-- カテゴリボタン -->
				<!--   <div>
    <form action="bbs_list.php" method="GET">
      <button type='submit' name='category' value="1">eat</button>
      <button type='submit' name='category' value='2'>activity</button>
      <button type='submit' name='category' value='3'>life</button>
      <button type='submit' name='category' value='4'>other</button>
    </form> -->
				<!-- 記事の出力 -->
				<article class="plw">
					<section>
						<?php foreach ($feeds as $feed):?>
						<form action="bbs.php" method="POST">
							<!-- 1件づつ処理 -->
							<div class="bww">
								<div class="bwi">
									<ul>
										<li>
											<?php echo $feed['name'] ?>
										</li>
										<li>
											<?php echo $feed['created'] ?>
										</li>
									</ul>
								</div>
								<div class="planc">
									<?php echo $feed['feed'] ?>
								</div>
							</div>
							<input type="hidden" name="feed_id" value="<?php echo $feed['id'] ?>">
							<input type="submit" name="submit" value="JOIN..?"><br>
						</form>
						<?php endforeach; ?>
					</section>
				</article>
				<div>
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
								<a href="bbs_list.php?page=<?php echo $page -1; ?>">Newer</a>
								<?php endif; ?>
							</li>
							<!-- 最後のページではOlderは押せない -->
							<li>
								<?php if ($page == $last_page):?>
								<a>Older</a>
								<!-- それ以外の場合 -->
								<?php else: ?>
								<a href="bbs_list.php?page=<?php echo $page +1; ?>">Older</a>
								<?php endif; ?>
							</li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php include ('../footer/footer.php'); ?>
</body>
</html>