<?php
    date_default_timezone_set('Asia/Manila'); //フィリピン時間に設定
    session_start();

echo '<pre>';
var_dump ($_POST);
echo '</pre>';

      $name = '';
      $email = '';
      $school = '';
      $gender = '';
      $age = '';
      $school = '';
      $other = '';
    // バリデーションに引っかかった項目を入れる
    $errors = array();


      // $errors = array();

      //バリデーション

    if(!empty($_POST)) {
      $name = $_POST['name'];
      $email = $_POST['email'];
      $password = $_POST['password'];
      $str_age = $_POST['age'];
      $age = (int) $str_age;
      $school = $_POST['school'];
      $other = $_POST['other'];

      if(isset($_POST['gender'])){
      $str_gender = $_POST['gender'];
      $gender = (int) $str_gender;
    }
// echo '<pre>';
// var_dump ($gender);
// echo '</pre>';

        //ユーザー名の空チェック
      if($name == '') {
        $errors['name'] = 'blank';
      }

        //メールアドレスの空チェック
      if($email == '') {
        $errors['email'] = 'blank';
      }

        //パスワードの空チェック
        $count = strlen($password);//hogehogeとパスワードを入力した際、8が$countに代入される
        if($password == '') {
          $errors['password'] = 'blank';
        } elseif($count < 4 || 16 < $count) {
            // ||演算子を使って4文字未満または16文字より多い場合にエラー配列にlengthを代入
          $errors['password'] = 'length';
        }

        //画像名を取得
        $file_name = $_FILES['img_name']['name'];
        if (empty($file_name)) {
            $errors['img_name'] = 'blank';
        }else{
              $file_type = substr($file_name,-3);
              echo '<br>';
        if ($file_type != 'jpg' && $file_type != 'png' && $ext != 'gif') {
            $errors['img_name'] = 'type';
        }
        }


          //性別の空チェック
          if($gender == '') {
            $errors['gender'] = 'blank';
          }

          //年齢の空チェック
          if($age == '') {
            $errors['age'] = 'blank';
          }

          //語学学校チェック
          if($school == '') {
            $errors['school'] = 'blank';
          }

          //備考チェック
          if($other == '') {
            $errors['other'] = 'blank';
          }

        //エラーがなかったときの処理
          if(empty($errors)) {
            $date_str = date('YmdHis');
            $submit_file_name = $date_str . $file_name;

// echo '<pre>';
// var_dump ($submit_file_name);
// echo '</pre>';
// die();

            move_uploaded_file(
              $_FILES['img_name']['tmp_name'], 
              '../user_profile_img/' . $submit_file_name);

            $_SESSION['register'] = $_POST;
            $_SESSION['register']['img_name'] = $submit_file_name;


            header('Location: check.php');
            // exit();
          }
        }



        ?>

        <!DOCTYPE html>
        <html lang="ja">
        <head>
          <meta charset="utf-8">
          <title>Team Project</title>

        </head>
        <body>
          <h2>Create Account</h2>
          <form action="signup.php" method="POST" enctype="multipart/form-data">
            <div>
              <label for="name">ユーザー名(Username)</label>
              <input type="text" name="name" placeholder="username" value="<?php echo htmlspecialchars($name); ?>">
              <?php if(isset($errors['name']) && $errors['name'] == 'blank') : ?>
                <p>Please enter username</p>
              <?php endif; ?>
            </div>

            <div>
              <label for="email">メールアドレス(email)</label>
              <input type="email" name="email" placeholder="example@.com" value="<?php echo htmlspecialchars($email); ?>">
              <?php if(isset($errors['email']) && $errors['email'] == 'blank') : ?>
                <p>Please enter email</p>
              <?php ; ?>
            </div>

            <div>
              <label for="password">パスワード(password)</label>
              <input type="password" name="password" placeholder="password" >
              <?php if(isset($errors['password']) && $errors['password'] == 'blank'): ?>
                <span class="red">Please Enter Password</span>
              <?php endif; ?>


              <?php if(isset($errors['password'])&& $errors['password'] == 'length'):?>
              <span class="red">パスワードをは4〜16文字で入力して下さい。<s></s></span>
              <?php endif; ?>


            <div>
              <label for="img_name">プロフィール画像(profile image)</label>
              <input type="file" name="img_name" accept="image/*">
              <?php if(isset($errors['img_name']) && $errors['img_name'] == 'blank'):?>
                <p>画像を選択して下さい(Pleae choose a your  image picture)</p>
              <?php endif; ?>
              <?php if(isset($errors['img_name']) && $errors['img_name'] == 'type'):?>
                <p>拡張子が「jpg」「png」「gif」の画像を選択してください(Please select an image with the extension "jpg" "png" "gif")</p>
              <?php endif; ?>
            </div>


            <div>
              <input type="radio" name="gender" value="1">男 
              <input type="radio" name="gender" value="2">女
              <input type="radio" name="gender" value="3">その他
              <?php if(isset($errors['gender']) && $errors['gender'] == 'blank'): ?>
                <p>Please select your gender</p>
              <?php endif; ?>
             </div>

            <div>
              <label for="age">年齢(Age)</label>
              <input type="text" name="age" placeholder="age" value="<?php echo $age; ?>">
              <?php if(isset($errors['age']) && $errors['age'] == 'blank') : ?>
                <p>Please enter your age</p>
              <?php endif; ?>
            </div>

            <div>
              <label for="school">語学学校(School)</label>
              <input type="text" name="school" placeholder="QQ English" value="<?php echo htmlspecialchars($school);?>">
              <?php if(isset($errors['school']) && $errors['school'] == 'blank') : ?>
                <p>Please enter your school</p>
              <?php endif; ?>
            </div>

            <div>
              <label for="other">備考(other)</label>
              <input type="text" name="other"  value="<?php echo htmlspecialchars($other);?>">
              <?php if(isset($errors['other']) && $errors['other'] == 'blank') : ?>
                <p>Please enter your other</p>
              <?php endif; ?>
            </div>

            <div>
              <input type="submit" value="確認(submit)">
            </div>

          </form>
        </body>
        </html>