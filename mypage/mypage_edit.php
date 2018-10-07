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

    // $sql = 'SELECT `id`, `name`, `img_name` FROM `users` WHERE `id` = ?';
    // $data = [$signin_user_id];
    // $stmt = $dbh->prepare($sql);
    // $stmt->execute($data);

    // // フェッチする
    // $user = $stmt->fetch(PDO::FETCH_ASSOC);

    $sql = 'SELECT * FROM `users` WHERE `id` = ?';
    $data = [$signin_user_id];
    $stmt = $dbh->prepare($sql);
    $stmt->execute($data);

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    $name = $user['name'];
    $email = $user['email'];
    $img_name = $user['img_name'];
    $gender = $user['gender'];
    $age = $user['age'];
    $school = $user['school'];
    $other = $user['other'];

echo '<pre>';
var_dump ($_POST);
echo '</pre>';

    if(isset($_POST['update_name'])){
      $update_name = $_POST['update_name'];
    }

   if(empty($_POST['email'])){
      $edit_email = $_POST['email'];
    }

    if(empty($_POST['img_name'])){
      $edit_img_name = $_POST['img_name'];
    }

    if(empty($_POST['password'])){
      $edit_password = $_POST['password'];
    }

    if(empty($_POST['gender'])){
      $edit_gender = $_POST['gender'];
    }

    if(empty($_POST['age'])){
      $edit_age = $_POST['age'];
    }

    if(empty($_POST['school'])){
      $edit_school = $_POST['school'];
    }

    if(empty($_POST['other'])){
      $edit_other = $_POST['other'];
    }


  $sql='UPDATE users SET name = ?, email= ?, password = ?, img_name = ?, gender = ?, age = ?, school = ?, other = ? WHERE id = ?';
  $data = [$update_name,$update_email,$update_password,$update_img_name,$update_gender,$update_age,$update_school,$update_other
  ];
  $stmt = $dbh->prepare($sql);
  $stmt->execute($data);

//     // バリデーションに引っかかんた項目を入れる
//       $name = '';
//       $email = '';
//       $school = '';
//       $gender = '';
//       $age = '';
//       $school = '';
//       $other = '';

//     $errors = array();

//       if(!empty($_POST)) {
//       $name = $_POST['name'];
//       $email = $_POST['email'];
//       $password = $_POST['password'];
//       $str_age = $_POST['age'];
//       $age = (int) $str_age;
//       $school = $_POST['school'];
//       $other = $_POST['other'];

//       if(isset($_POST['gender'])){
//       $str_gender = $_POST['gender'];
//       $gender = (int) $str_gender;
//     }
// // echo '<pre>';
// // var_dump ($gender);
// // echo '</pre>';

//         //ユーザー名の空チェック
//       if($name == '') {
//         $errors['name'] = 'blank';
//       }

//         //メールアドレスの空チェック
//       if($email == '') {
//         $errors['email'] = 'blank';
//       }

//         //パスワードの空チェック
//         $count = strlen($password);//hogehogeとパスワードを入力した際、8が$countに代入される
//         if($password == '') {
//           $errors['password'] = 'blank';
//         } elseif($count < 4 || 16 < $count) {
//             // ||演算子を使って4文字未満または16文字より多い場合にエラー配列にlengthを代入
//           $errors['password'] = 'length';
//         }

//         //画像名を取得
//         $file_name = $_FILES['img_name']['name'];
//         if (empty($file_name)) {
//             $errors['img_name'] = 'blank';
//         }else{
//               $file_type = substr($file_name,-3);
//               echo '<br>';
//         if ($file_type != 'jpg' && $file_type != 'png' && $ext != 'gif') {
//             $errors['img_name'] = 'type';
//         }
//         }


//           //性別の空チェック
//           if($gender == '') {
//             $errors['gender'] = 'blank';
//           }

//           //年齢の空チェック
//           if($age == '') {
//             $errors['age'] = 'blank';
//           }

//           //語学学校チェック
//           if($school == '') {
//             $errors['school'] = 'blank';
//           }

//           //備考チェック
//           if($other == '') {
//             $errors['other'] = 'blank';
//           }

//         //エラーがなかったときの処理
//           if(empty($errors)) {
//             $date_str = date('YmdHis');
//             $submit_file_name = $date_str . $file_name;


// // echo '<pre>';
// // var_dump ($submit_file_name);
// // echo '</pre>';
// // die();

//             move_uploaded_file(
//               $_FILES['img_name']['tmp_name'], 
//               '../user_profile_img/' . $submit_file_name);

//             $_SESSION['register'] = $_POST;
//             $_SESSION['register']['img_name'] = $submit_file_name;

//             header('Location: mypage.php');
//           }
//         }
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
    <form action="mypage_edit.php" method="POST">
      
      <!-- イメージ画像 -->
    <?php if(isset($_POST['img_name'])):?>
      <img src="../user_profile_img/<?= $user['img_name']?>" width="60" class="img-thumbnail" ><br>
      <lavel for="img_name">イメージ画像を変更する</lavel><br>
      <input type="file" name="img_name" value="">
       <input type="submit" name="update_img_name" value="update">
    <?php endif; ?>

    <?php if(isset($_POST['name'])):?>
      <lavel for="name">USER NAME:</lavel>
       <input type="text" name="name" value="<?php echo $name;?>">
       <input type="submit" name="update_name" value="update">
    <?php endif; ?>


    <?php if(isset($_POST['email'])):?>
      <lavel for="email">E-MAIL:</lavel>
      <input type="email" name="email" value="<?php echo $email;?>">
      <input type="submit" name="update_email" value="update">
    <?php endif; ?>


    <?php if(isset($_POST['password'])):?>
      <lavel for="password">PASSWORD</lavel><br>
      <input type="password" name="password_now">(現在のパスワード)<br>
      <input type="password" name="password_new1">(新しいパスワード)<br>
      <input type="password" name="password_now2">(新しいパスワードの再入力)
      <input type="submit" name="update_password" value="update">
    <?php endif; ?>


    <?php if(isset($_POST['gender'])):?>
      <lavel for="email">GENDER:</lavel><br> 
      <input type="radio" name="gender" value="1">男
      <input type="radio" name="gender" value="2">女
      <input type="radio" name="gender" value="3">表示しない
      <input type="submit" name="update_gender" value="update">
    <?php endif; ?>


    <?php if(isset($_POST['age'])):?>
      <lavel for="age">AGE:</lavel>
      <input type="text" name="age" value="<?php echo $age?>">
      <input type="submit" name="update_age" value="update">
    <?php endif; ?>


    <?php if(isset($_POST['school'])):?>
      <lavel for="school">SCHOOL:</lavel>
      <input type="text" name="school" value="<?php echo $school?>">
      <input type="submit" name="update_school" value="update">
    <?php endif; ?>


    <?php if(isset($_POST['other'])):?>
      <lavel for="other">INTRODUCTION:</lavel>
      <input type="text" name="other" value ="<?php echo $other?>">
      <input type="submit" name="update_other" value="update">
    <?php endif; ?>
    </form>
  </div>
</body>
</html>