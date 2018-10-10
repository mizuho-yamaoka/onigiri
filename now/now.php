<?php
  	session_start();
  	require_once('../dbconnect.php');

      // ログイン不要のページなのでセッションの存在の確認は不要
  	// if (!isset($_SESSION['register']['id'])) { //①:セッションに保存する一つ目にカラム名をhogehogeに入れる
  			// }

  	$signin_user_id=$_SESSION['register']['id'];//②:①同様

  	$sql='SELECT `id`,`name`,`img_name` FROM `users` WHERE `id`=?';//③:insert,select時に必要なカラム名を指定＊変更があれば
  	$data=[$signin_user_id];
  	$stmt=$dbh->prepare($sql);
  	$stmt->execute($data);

  	$user=$stmt->fetch(PDO::FETCH_ASSOC);

    $user_img_name = $user['img_name'];

    $murmur = '';
    $errors = [];

    // バリデーション
    if(!empty($_POST)){
        $murmur = $_POST['murmur'];
        if ($murmur == '') {
            $errors['murmur']='blank';
       }
    }

    // 投稿機能
    if (!empty($_POST['murmur'])) {
        $murmur=$_POST['murmur'];

          $sql='INSERT INTO `murmurs` SET `murmur`=?,`user_id`=?,`user_img_name` = ?,`created`=NOW()';
          $data=[$murmur,$user['id'],$user_img_name];
          $stmt=$dbh->prepare($sql);
          $stmt->execute($data);

          header('Location:now.php');
          exit();
    }

    // テーブル名変更とカラム名の追加（ユーザーイメージ）をしたのでSQL文を変更
    $sql = "SELECT m.*, u.name FROM murmurs AS m LEFT JOIN users AS u ON m.user_id = u.id ORDER BY m.created DESC";
    // $sql='SELECT `f`.*,`u`.`name`,`u`.`img_name` FROM `murmurs` AS `f` LEFT JOIN `users` AS `u` ON `f`.`user_id`=`u`.`id` ORDER BY `f`.`created` DESC';//④:③同様
    $stmt=$dbh->prepare($sql);
    $stmt->execute();

    $murmur=array();
    while (true) {
        $record=$stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($record==false) {
            break;
        }
        $murmurs[]=$record;
    }
?>

<!DOCTYPE html>
<html lang="ja">
<head>
	<title></title>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="assets/css/bootstrap.css">
</head>
<body>
	<h1>セブつぶやき掲示板</h1><!--もっとセンスのあるやつに書き換えてください笑  -->
	<div class="container">
		<div class="row">
			<div class="col-xs-4">
      	<img src="../user_profile_img/<?php echo $user_img_name ?>" width="100" class="img-thumbnail">
			</div>
		</div>
	</div>
    <div>
    	<form action="" method="POST">
    		<input type="text" name="murmur"> 
    		<br>
    		<?php if (isset($errors['murmur']) && $errors['murmur'] == 'blank'):?> 
    			<p class="red">内容を入力してください</p>
    	  <?php endif; ?><br>
    		<input type="submit" value="投稿する">
    	</form>
    </div>
	<div>
    <!-- 表示するユーザー画像はデータベース（murmur）より参照 -->
		<?php foreach($murmurs as $murmur):?>
         <img src="../user_profile_img/<?php echo $murmur['user_img_name']?>" width="70" class="img-thumbnail">
        <div><?php echo $murmur['name'] ?></div>
        <div><?php echo $murmur['murmur'] ?></div>
        <div><?php echo $murmur['created'] ?></div>
	    <?php endforeach;?>
	    </div>
	</div>

</body>
</html>
