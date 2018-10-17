<?php
session_start();
require('../dbconnect.php');
// 必要な値を取り出す

$user_id = $_SESSION['register']['id'];
$comment = $_POST['write_comment'];
$feed_id = $_POST['feed_id'];
// DBに保存する
$sql = "INSERT INTO `feed_comments` SET comments = ?, user_id = ?, feed_id = ?, created = NOW()";
$data = [$comment,$user_id,$feed_id];
$stmt = $dbh->prepare($sql);
$stmt->execute($data);
// 画面遷移
$_SESSION['feed_id'] = $_POST['feed_id'];
header('Location: bbs.php');
exit();
?>