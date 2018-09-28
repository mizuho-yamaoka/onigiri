<?php

    date_default_timezone_set('Asia/Manila'); //フィリピン時間に設定
    session_start();
    $errors = array();

    if (isset($_GET['action']) && $_GET['action'] == 'rewrite') {
      $_POST['input_name'] = $_SESSION['register']['name'];
      $_POST['input_email'] = $_SESSION['register']['email'];
      $_POST['input_password'] = $_SESSION['register']['password'];
      $_POST['input_gender'] = $_SESSION['register']['gender'];
      $_POST['input_age'] = $_SESSION['register']['age'];
      $_POST['input_school'] = $_SESSION['register']['school'];
      $_POST['input_other'] = $_SESSION['register']['other'];

      $errors['rewrite'] = true;
    }

      $name = '';
      $email = '';
      $school = '';
      $gender = '';
      $age = '';
      $school = '';
      $other = '';
      $errors = array();

    if(!empty($_POST)) {
      $name = $_POST['input_name'];
      $email = $_POST['input_email'];
      $password = $_POST['input_password'];
      $gender = $_POST['input_gender'];
      $age = $_POST['input_age'];
      $school = $_POST['input_school'];
      $other = $_POST['input_other'];

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
        $file_name = '';
        if(!isset($_GET['action'])) {
          $file_name = $_FILES['input_img_name']['name'];
        }
        if(!empty($file_name)) {
            //
          $file_type = substr($file_name, -3);
            $file_type = strtolower($file_type); //大文字が含まれていた場合すべて小文字化
            if($file_type !='jpg' && $file_type !='png' && $file_type !='gif') {
              $errors['img_name'] = 'type';
            }
          } else {
            $errors['img_name'] = 'blank';
          }

          //性別の空チェック
          if($gender == '') {
            $errors['gender'] = 'blank';
          }

          //年齢の空チェック
          if($age == '') {
            $age['age'] = 'blank';
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

            move_uploaded_file($_FILES['input_img_name']['tmp_name'], '../user_profile_img/' . $submit_file_name);

            $_SESSION['register']['name'] = $_POST['input_name'];
            $_SESSION['register']['email'] = $_POST['input_email'];
            $_SESSION['register']['password'] = $_POST['input_password'];


            $_SESSION['register']['img_name'] = $submit_file_name;

            $_SESSION['register']['gender'] = $_POST['input_gender'];
            $_SESSION['register']['age'] = $_POST['input_age'];
            $_SESSION['register']['school'] = $_POST['input_school'];
            $_SESSION['register']['other'] = $_POST['input_other'];


            header('Location: check.php');
            exit();
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
          <form method="POST" action="signup.php" enctype="multipart/form-data">
            <div>
              <label for="name">ユーザー名(Username)</label>
              <input type="text" name="input_name" placeholder="username" value="<?php echo htmlspecialchars($name); ?>">
              <?php if(isset($errors['name']) && $errors['name'] == 'blank') { ?>
                <p>Please enter username</p>
              <?php } ?>
            </div>

            <div>
              <label for="email">メールアドレス(email)</label>
              <input type="email" name="input_email" placeholder="example@.com" value="<?php echo htmlspecialchars($email); ?>">
              <?php if(isset($errors['email']) && $errors['email'] == 'blank') { ?>
                <p>Please enter email</p>
              <?php } ?>
            </div>

            <div>
              <label for="email">パスワード(password)</label>
              <input type="password" name="input_password" placeholder="password" value="">
              <?php if(isset($errors['password']) && $errors['password'] == 'blank') { ?>
                <p>Please enter password</p>
              <?php } ?>

              <!-- <?php if(isset($errors['password']) && $errors['password'] == 'length') { ?>
                <p>Password must be 4 to 16 characters</p>
                <?php } ?> -->

                <?php if(!empty($errors)) { ?>
                  <p class="text-danger">パスワードを再度入力して下さい(Please enter password again)</p>
                <?php } ?>
              </div>

            <div>
              <label for="img_name">プロフィール画像(profile image)</label>
              <input type="file" name="input_img_name" accept="image/*">
              <?php if(isset($errors['img_name']) && $errors['img_name'] == 'type') { ?>
                <p>拡張子が「jpg」「png」「gif」の画像を選択してください(Please select an image with the extension "jpg" "png" "gif")</p>
              <?php } ?>
            </div>


            <div>
              <input type="radio" name="input_gender" value="<?php echo htmlspecialchars($gender); ?>"> 男
              <input type="radio" name="input_gender" value="<?php echo htmlspecialchars($gender); ?>"> 女
              <input type="radio" name="input_gender" value="<?php echo htmlspecialchars($gender); ?>"> その他
              <?php if(isset($errors['gender']) && $errors['gender'] == 'blank') { ?>
                <p>Please select your gender</p>
              <?php } ?>
          </div>

            <div>
              <label for="age">年齢(Age)</label>
              <input type="text" name="input_age" placeholder="age" value="<?php echo htmlspecialchars($age); ?>">
              <?php if(isset($errors['age']) && $errors['age'] == 'blank') { ?>
                <p>Please enter your age</p>
              <?php } ?>
            </div>

            <div>
              <label for="school">語学学校(School)</label>
              <input type="text" name="input_school" placeholder="QQ English" value="<?php echo htmlspecialchars($school);?>">
              <?php if(isset($errors['school']) && $errors['school'] == 'blank') { ?>
                <p>Please enter your school</p>
              <?php } ?>
            </div>

            <div>
              <label for="other">備考(other)</label>
              <input type="text" name="input_other"  value="<?php echo htmlspecialchars($other);?>">
              <?php if(isset($errors['other']) && $errors['other'] == 'blank') { ?>
                <p>Please enter your other</p>
              <?php } ?>
            </div>

            <div>
              <input type="submit" value="確認(submit)">
            </div>

          </form>
        </body>
        </html>