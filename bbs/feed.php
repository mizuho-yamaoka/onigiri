<?php
session_start();
    require_once('../dbconnect.php');

    // 閲覧制限
    // サインイン処理をしていれば、セッション処理の中にidが保存されているので、idが存在するかどうかでこのタイムラインページの閲覧を制限する。
    if (empty($_SESSION) || !isset($_SESSION['register']['id'])) {
      header('Location: ../signin.php');
      exit();
    }

    $signin_user_id = $_SESSION['register']['id'];
    //SELECTで現在サインインしているユーザーの情報をusersテーブルから読み込む
    $sql = 'SELECT `id`, `name`, `img_name` FROM `users` WHERE `id` = ?';
    $data = [$signin_user_id];
    $stmt = $dbh->prepare($sql);
    $stmt->execute($data);

    // フェッチする
    $user = $stmt->fetch(PDO::FETCH_ASSOC);


    // 投稿機能
    // エラーがあれば、この中に入れる
    $errors = [];
    // ポスト送信できたら
    if (!empty($_POST)) {
      // テキストエリアの内容を取り出す
      $username = $_POST['username'];
      $feed = $_POST['body'];

      //バリデーション処理
      // 投稿の空チェック
      if ($feed != '') {
        // 空じゃなければ
        // 投稿処理
        $sql = 'INSERT INTO `feeds` SET `feed`= ?, `user_id`= ?, `created` = NOW()';
        $data = [$feed,$username];
        $stmt = $dbh->prepare($sql);
        $stmt->execute($data);

        header('Location: bbs_list.php');
        exit();
      }else
        // 空だったら
        $errors['feed'] = 'blank';
    }

?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>ブログ投稿ページ</title>
</head>
<body>

<p>ログインしているユーザー:<?php echo $user['name']?>さん</p>
<img src="../user_profile_img/<?= $user['img_name']?>" width="60" class="img-thumbnail">


<form action="" method="POST">

  <input type="hidden" name="username" value="<?php echo $user['id']; ?>">
  <p>BBS投稿</p>
  <input type="text" name="body" placeholder="notice board">
  <br>


  <?php if(isset($errors['feed']) && $errors['feed'] == 'blank'): ?>
    <p class="red">投稿データを入力して下さい</p>
  <?php endif; ?>


  <input type="submit" value="投稿する"><br>

  <a href="bbs_list.php">一覧へ戻る</a>
</form>
</body>
</html>