<?php
session_start();
    require_once('../dbconnect.php');

    echo '<pre>';
    var_dump($_POST);
    echo '</pre>';

    // 閲覧制限
    // サインイン処理をしていれば、セッション処理の中にidが保存されているので、idが存在するかどうかでこのタイムラインページの閲覧を制限する。
    if (!isset($_SESSION['register']['id'])) {
      header('../location: signin.php');
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
      $title = $_POST['title'];
      $post = $_POST['body'];
      $category = $_POST['category'];

      
      //バリデーション処理
      // 投稿の空チェック
      if ($post != '' && $title != '' && $category != '') {
        // 空じゃなければ
        // 投稿処理
        $sql = 'INSERT INTO `posts` SET `title`= ?, `post`= ?, `user_id`= ?, `category_id`= ?, `created` = NOW()';
        $data = [$title,$post,$username,$category];
        $stmt = $dbh->prepare($sql);
        $stmt->execute($data);

        header('Location: blog_list.php');
        exit();
      }else
        // 空だったら
        $errors['post'] = 'blank';
        $errors['title'] = 'blank';
        $errors['catogory'] = 'not_chosen';
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
  <br>
  <input type="text" name="title" placeholder="Title">
  <br>
  <input type="text" name="body" placeholder="Body of letter">
  <br>
  <input type="radio" name="category" value="1">EAT
  <input type="radio" name="category" value="2">ACTIVITY
  <input type="radio" name="category" value="3">LIFE
  <input type="radio" name="category" value="4">OTHER
  <br>


  <?php if(isset($errors['title']) && $errors['title'] == 'blank'): ?>
    <p class="red">タイトルを入力して下さい</p>
  <?php endif; ?>
  <?php if(isset($errors['post']) && $errors['post'] == 'blank'): ?>
    <p class="red">投稿データを入力して下さい</p>
  <?php endif; ?>
  <?php if(isset($errors['category']) && $errors['category'] == 'not_chosen'): ?>
    <p class="red">カテゴリーを選択して下さい</p>
  <?php endif; ?>

  <input type="submit" value="投稿する"><br>

  <a href="blog_list.php">一覧へ戻る</a>
</form>
</body>
</html>