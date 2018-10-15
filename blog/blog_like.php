<?php
    require_once('../dbconnect.php');
// echo 'Hello, world!';

$user_id = $_POST['user_id'];
$post_id = $_POST['post_id'];


if(isset($_POST['is_unlike'])){
    $sql ='DELETE FROM `post_likes` WHERE `user_id` = ? AND `post_id` = ?';
}else{
$sql = 'INSERT INTO `post_likes`SET `user_id` = ?,`post_id` = ?';
}
$data = [$user_id,$post_id];
$stmt = $dbh->prepare($sql);
$res = $stmt->execute($data);
// 結果を返す
// JavaScriotで使えるようにjsonエンコードして返す
echo json_encode($res);
