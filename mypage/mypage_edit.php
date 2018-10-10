  <?php
    session_start();
    require_once('../dbconnect.php');

    // 閲覧制限
    // サインイン処理をしていれば、セッション処理の中にidが保存されているので、idが存在するかどうかでこのタイムラインページの閲覧を制限する。
    if (!isset($_SESSION['register']['id'])) {
      header('../location: signin.php');
    }
    $signin_user_id = $_SESSION['register']['id'];
    //SELECTで現在サインインしているユーザーの情報をusersテーブルから読み込む


    $sql = 'SELECT * FROM `users` WHERE `id` = ?';
    $data = [$signin_user_id];
    $stmt = $dbh->prepare($sql);
    $stmt->execute($data);

    $user = $stmt->fetch(PDO::FETCH_ASSOC);


    // echo '<pre>';
    // var_dump();
    // echo '</pre>';
// placeholderに表示するユーザーデータ
    $name = $user['name'];
    $email = $user['email'];
    $password = $user['password'];
    $img_name = $user['img_name'];
    $gender = $user['gender'];
    $age = $user['age'];
    $school = $user['school'];
    $other = $user['other'];

// 変更しないタプル処理用の変数を作る
    $update_name = $name;
    $update_email = $email;
    $submit_file_name = $img_name;
    $hash_password =$password; 
    $update_gender = $gender;
    $update_age = $age;
    $update_school = $school;
    $update_other = $other;

    $count = '';
    $errors =array();


    // if(!empty($_POST)){
      
echo '<pre>';
var_dump ($_POST);
echo '</pre>';

    if(!empty($_POST['update_name'])){
      $update_name = $_POST['update_name'];
    }

    if(!empty($_POST['update_email'])){
      $update_email = $_POST['update_email'];
    }

    if(!empty($_FILES['update_img_name']['name'])){
      $file_name = $_FILES['update_img_name']['name'];
        $file_type = substr($file_name,-3);
        echo '<br>';
        if ($file_type != 'jpg' && $file_type != 'png' && $ext != 'gif') {
            $errors['img_name'] = 'type';
        }
        //エラーがなかったときの処理
          if(empty($errors['img_name'])) {
            $date_str = date('YmdHis');
            $submit_file_name = $date_str . $file_name;

            move_uploaded_file(
              $_FILES['update_img_name']['tmp_name'], 
              '../user_profile_img/' . $submit_file_name);
          }
    }

    // パスワード
    // ３つとも入力されているか
    if(!empty($_POST['update_password_now']) && 
      !empty($_POST['update_password_new1']) && 
      !empty($_POST['update_password_new2'])){
      // 古いパスワードを間違えている場合
      if(!password_verify($_POST['update_password_now'],$password)){
        $errors['password'] = 'invalid';
      }
      // 新しいパスワードが一致しない場合
      if($_POST['update_password_new1'] != $_POST['update_password_new2']){
        $errors['password'] = 'mistatch';
      }
      // 文字数エラー
      $count = strlen($_POST['update_password_new1']);
      if($count < 4 || 16 < $count) {
        // ||演算子を使って4文字未満または16文字より多い場合にエラー配列にlengthを代入
        $errors['password'] = 'length';
      }
                $hash_password = password_hash($_POST['update_password_new1'],PASSWORD_DEFAULT);
    } else {
      // ３つのうち１つ以上がからの場合
      $errors['password'] = 'mistake';
    }
    // エラーがなにもない場合DBに保存する
    if(empty($errors['password'])){
      $hash_password = password_hash($_POST['update_password_new1'],PASSWORD_DEFAULT);
    }




    if(!empty($_POST['update_gender'])){
      $update_gender = $_POST['update_gender'];
    }

    if(!empty($_POST['update_age'])){
      $update_age = $_POST['update_age'];
    }
    

    if(!empty($_POST['update_school'])){
      $update_school = $_POST['update_school'];
    }

    if(!empty($_POST['update_other'])){
      $update_other = $_POST['update_other'];
    }

    if(!empty($_POST)){


  $sql='UPDATE users SET name = ?, email= ?, password = ?, img_name = ?, gender = ?, age = ?, school = ?, other = ? WHERE id = ?';
  $data = [$update_name,$update_email,$hash_password,$submit_file_name,$update_gender,$update_age,$update_school,$update_other,$signin_user_id
  ];
  $stmt = $dbh->prepare($sql);
  $stmt->execute($data);
  header('Location: mypage.php');
  exit();

    }



?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>mypage</title>
</head>
<body>
  <h3>編集する</h3>
  <div>
    <form action="mypage_edit.php" method="POST" enctype="multipart/form-data">
      
      <!-- イメージ画像 -->
    <?php if(isset($_GET['img_name'])):?>
      <img src="../user_profile_img/<?= $user['img_name']?>" width="60" class="img-thumbnail" ><br>
      <lavel for="img_name">イメージ画像を変更する</lavel><br>
      <input type="file" name="update_img_name" accept="image/*">
       <input type="submit" name="img_name" value="update">
    <?php endif; ?>
       
    <?php if(isset($_GET['name'])):?>
      <lavel for="name">USER NAME:</lavel>
       <input type="text" name="update_name" placeholder="<?php echo $name;?>">
       <input type="submit" name="name" value="update">
    <?php endif; ?> 
<!--     <?php if($update_name == ''): ?>
      <input type="hidden" name="update_name" value="<?php echo $name;?>">
    <?php endif ;?> -->

    <?php if(isset($_GET['email'])):?>
      <lavel for="email">E-MAIL:</lavel>
      <input type="email" name="update_email" placeholder="<?php echo $email;?>">
      <input type="submit" name="email" value="update">
    <?php endif; ?>
<!--     <?php if($update_email == ''): ?>
      <input type="hidden" name="update_email" value="<?php echo $email;?>">
    <?php endif ;?> -->


    <?php if(isset($_GET['password'])):?>
      <lavel for="password">PASSWORD</lavel><br>
      <input type="password" name="update_password_now" placeholder="your password">(現在のパスワード)<br>
      <input type="password" name="update_password_new1" placeholder="new password">(新しいパスワード)<br>
      <input type="password" name="update_password_new2" placeholder="new password (check)">(新しいパスワードの再入力)
      <input type="submit" name="password" value="update">
    <?php endif; ?>


    <?php if(isset($_GET['gender'])):?>
      <lavel for="email">GENDER:</lavel><br> 
      <input type="radio" name="update_gender" value="1">Male
      <input type="radio" name="update_gender" value="2">Female
      <input type="radio" name="update_gender" value="3">Not Chosen
      <input type="submit" name="gender" value="update">
    <?php endif; ?>

    <?php if(isset($_GET['age'])):?>
      <lavel for="age">AGE:</lavel>
      <input type="text" name="update_age" placeholder="<?php echo $age?>">
      <input type="submit" name="age" value="update">
    <?php endif; ?>


    <?php if(isset($_GET['school'])):?>
      <lavel for="school">SCHOOL:</lavel>
      <input type="text" name="update_school" placeholder="<?php echo $school?>">
      <input type="submit" name="school" value="update">
    <?php endif; ?>


    <?php if(isset($_GET['other'])):?>
      <lavel for="other">INTRODUCTION:</lavel>
      <input type="text" name="update_other" placeholder="<?php echo $other?>">
      <input type="submit" name="other" value="update">
    <?php endif; ?>

    </form>
  <a href="mypage.php">Back to MyPage</a>
  </div>
</body>
</html>