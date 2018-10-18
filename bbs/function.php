<?php

// 色々なページから何度も行っているような処理をここに書いていく。

// フィード１件に対してなされたコメントの一覧をを取得する処理
function get_comments($dbh,$feed_id){
  // SQL文を用意
  $sql = "SELECT c.* ,u.name, u.img_name FROM feed_comments AS c LEFT JOIN users AS u ON c.user_id = u.id WHERE `feed_id` = ?";

  // SQLを発行
$data = [$feed_id];
$stmt = $dbh->prepare($sql);
$stmt->execute($data);
  // 結果を返す
$comments = [];
while(true){
  $comment = $stmt->fetch(PDO::FETCH_ASSOC);
  if($comment == false){
    break;
  }
  $comments[] = $comment;
}
  return $comments;
}
function count_comments($dbh,$feed_id){

  $sql = "SELECT COUNT(*) AS `comment_count` FROM `feed_comments` WHERE `feed_id` = ?";
  $data = [$feed_id];
  $stmt = $dbh->prepare($sql);
  $stmt->execute($data);
  $result = $stmt->fetch(PDO::FETCH_ASSOC);

  return $result['comment_count'];

}
?>