<?php
	session_start();
	require_once('../dbconnect.php');

	if (!isset($_SESSION['register']['id'])) { //①:セッションに保存する一つ目にカラム名をhogehogeに入れる

			}
			$signin_user_id=$_SESSION['register']['id'];//②:①同様

			$sql='SELECT `id`,`name`,`img_name` FROM `users` WHERE `id`=?';//③:insert,select時に必要なカラム名を指定＊変更があれば
			$data=[$signin_user_id];
			$stmt=$dbh->prepare($sql);
			$stmt->execute($data);
	
			$user=$stmt->fetch(PDO::FETCH_ASSOC);
	// 投稿機能
      $errors=[];
      if (!empty($_POST)) {
      	$murmur=$_POST['murmur'];
      	if ($murmur!='') {
      		$sql='INSERT INTO `murmur` SET `murmur`=?,`user_id`=?,`created`=NOW()';
      		$data=[$murmur,$user['id']];
      		$stmt=$dbh->prepare($sql);
      		$stmt->execute($data);

      		header('Location:now.php');
      		exit();
      	}
        else{
        	$errors['murmur']='blank';
         }
      }
			$sql='SELECT `f`.*,`u`.`name`,`u`.`img_name` FROM `murmur` AS `f` LEFT JOIN `users` AS `u` ON `f`.`user_id`=`u`.`id` ORDER BY `f`.`created` DESC';//④:③同様
			$stmt=$dbh->prepare($sql);
			$stmt->execute();

            
			$murmur=array();
			while (true) {
			  $record=$stmt->fetch(PDO::FETCH_ASSOC);
			  
			  if ($record==false) {
			  	break;
			  }
			  $murmur[]=$record;
			}
      
       $errors=[];
			
            
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
      	<img src="../user_profile_img/<?= $user['img_name']?>" width="100" class="img-thumbnail">
			</div>
		</div>
	</div>
    <div>
    	<form action="" method="POST">
    		<textarea name="murmur"></textarea>
    		<br>
    		<?php if (isset($errors['murmur'])&&$errors['murmur']=='blank'):?> 
    			<p class="red">を入力してください</p>
    	  <?php endif; ?><br>
    		<input type="submit" value="投稿する">
    	</form>
    </div>
	<div>
		<?php foreach($murmur as $murmurs):?>
         <img src="../user_profile_img/<?= $user['img_name']?>" width="70" class="img-thumbnail">
        <div><?php echo $murmurs['name'] ?></div>
        <div><?php echo $murmurs['created'] ?></div>
        <div><?php echo $murmurs['murmur'] ?></div>
	    <?php endforeach;?>
	    </div>
	</div>

</body>
</html>
