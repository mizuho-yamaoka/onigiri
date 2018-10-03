<?php
    session_start();
    require('../dbconnect.php');

    if(!isset($_SESSION['register'])) {
      header('Location: signup.php');
      exit();
    }
    // session_destroy();
echo '<pre>';
var_dump ($_SESSION);
echo '</pre>';




        $name = $_SESSION['register']['name'];
        $email = $_SESSION['register']['email'];
        $password = $_SESSION['register']['password'];
        $img_name = $_SESSION['register']['img_name'];
        $gender = $_SESSION['register']['gender'];
        $age = $_SESSION['register']['age'];
        $school = $_SESSION['register']['school'];
        $other = $_SESSION['register']['other'];

    //登録ボタンが押された時のみ処理するif文
    if(!empty($_POST)) {
      // パスワードをハッシュ化

      $hash_password = password_hash($password, PASSWORD_DEFAULT);

        $sql = 'INSERT INTO `users` SET `name` = ?, `email` = ?, `password` = ?, `img_name` = ?, `gender` =?, `age` = ?, `school` = ?, `other` = ?, `created` =NOW()';
        $data = array($name, $email, $hash_password, $img_name, $gender, $age, $school, $other);
        $stmt = $dbh->prepare($sql);
        $stmt->execute($data);

        unset($_SESSION['register']);
        header('Location: thanks.php');
        exit();
    }

    // 下記出力結果
    // → $2y$10$XdbJN1gMyCAoB77oDO2.fOZ1PcnPa2x105v/fkJlJ3raC3aR2LsCG

?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <title>CEBUFULL</title>
</head>
<body>
  <h2 class="text-center content_header">アカウント情報確認</h2>
  <img src="../user_profile_img/<?php echo htmlspecialchars($img_name);?>" width="60">
  <div>
    <span>ユーザー名(Username)</span>
    <p><?php echo htmlspecialchars($name); ?></p>
  </div>
  <div>
    <span>メールアドレス(Email)</span>
    <p><?php echo htmlspecialchars($email); ?></p>
  </div>
  <div>
    <span>パスワード(Password)</span>
    <p>●●●●●●●</p>
  </div>
  <div>
    <span>性別(Gender)</span>
    <p><?php echo htmlspecialchars($gender); ?></p>
  </div>
  <div>
    <span>年齢(Age)</span>
    <p><?php echo htmlspecialchars($age); ?></p>
  </div>
  <div>
    <span>語学学校(School)</span>
    <p><?php echo htmlspecialchars($school); ?></p>
  </div>
  <div>
    <span>備考(Other)</span>
    <p><?php echo htmlspecialchars($other); ?></p>
  </div>

  <form method="POST" action="">

    <!-- ④ -->
    <a href="signup.php?action=rewrite" class="btn btn-default">&laquo;&nbsp;戻る(back)</a> <br>
    <!-- ⑤ -->
    <input type="hidden" name="action" value="submit">
    <input type="submit" class="btn btn-primary" value="ユーザー登録(User registration)">
  </form>

</body>
</html>