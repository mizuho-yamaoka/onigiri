<?php
session_start();
require_once( '../dbconnect.php' );

    if (!isset($_SESSION['register']['id'])) {
      header('../location: signin.php');
    }
    $signin_user_id = $_SESSION['register']['id'];
    //SELECTで現在サインインしているユーザーの情報をusersテーブルから読み込む
    $sql = 'SELECT `id`, `name`, `img_name` FROM `users` WHERE `id` = ?';
    $data = [$signin_user_id];
    $stmt = $dbh->prepare($sql);
    $stmt->execute($data);

    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    // 編集するpost_id
    $edit_post_id = $_SESSION['post_id'];
    // 編集処理
    
        // $edit_title = '';
        // $edit_post = '';
    if (!empty($_POST['update'])) {
        $edit_title = $_POST['edit_title'];
        $edit_post = $_POST['edit_post'];

    $sql = 'UPDATE posts SET title = ?, post = ? WHERE id = ?';
    $data = [$edit_title,$edit_post,$edit_post_id];
    $stmt = $dbh->prepare($sql);
    $stmt->execute($data);
//    header('Location: ../mypage/mypage.php');
    exit();

    }

    $sql = 'SELECT * FROM posts WHERE id = ? ';
    $data = [$edit_post_id];
    $stmt = $dbh->prepare($sql);
    $stmt->execute($data);

    // フィード一覧を入れる配列
    $post = '';
    // フェッチ
    $record = $stmt->fetch( PDO::FETCH_ASSOC );

    // レコードがあれば追加
    $post = $record;

    ?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>ブログの編集</title>
</head>
<body>
  <form action="blog_edit.php" method="POST">
    <div>
      <label for="edit_blog_title">Title</label>
      <input type="text" name="edit_title" value="<?php echo $post['title']?>">
    </div>

    <div>
      <label for="edit_blog_post">Detail</label>
      <input type="text" name="edit_post" value="<?php echo $post['post']?>">
    </div>
    <div>
      <input type="submit" name="update" value="update" >
    </div>
  </form>
</body>
</html>