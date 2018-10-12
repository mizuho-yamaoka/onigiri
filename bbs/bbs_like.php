<?php
    require_once('dbconnect.php');
// echo 'Hello, world!';

$user_id = $_POST['user_id'];
$feed_id = $_POST['feed_id'];

echo '<pre>';
var_dump($_POST);
echo '</pre>';

if(isset($_POST['is_unlike'])){
    $sql ='DELETE FROM `feed_likes` WHERE `user_id` = ? AND `feed_id` = ?';
}else{
$sql = 'INSERT INTO `feed_likes`SET `user_id` = ?,`feed_id` = ?';
}
$data = [$user_id,$feed_id];
$stmt = $dbh->prepare($sql);
$res = $stmt->execute($data);
// 結果を返す
// JavaScriotで使えるようにjsonエンコードして返す
echo json_encode($res);

?>