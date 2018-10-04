<?php
    session_start();
    require_once('../dbconnect.php');


    $post_id = $_POST['post_id'];

    $sql= 'SELECT p.*,u.name FROM posts AS p LEFT JOIN users AS u ON p.user_id = u.id WHERE p.id = ?';
    $data = [$post_id];
    $stmt = $dbh->prepare($sql);
    $stmt->execute($data);

    // フィード一覧を入れる配列
    $post = '';
      // フェッチ
      $record = $stmt->fetch(PDO::FETCH_ASSOC);

      // レコードがあれば追加
      $post = $record;

?>


<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>test2</title>
</head>
<body>
  <div>
      <a href="post.php">投稿する</a> 

        <div><?php echo $post['name'] ?></div>
        <div><?php echo $post['title'] ?></div>
        <div><?php echo $post['post'] ?></div>
        <div><?php echo $post['created'] ?></div>

        <a href="blog_list.php">ブログ一覧に戻る</a>

  </div>
</body>
</html>