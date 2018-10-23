<?php
session_start();
// セッションの情報を破棄する
// $_SESSION変数の破棄
$_SESSION = [];
// サーバー内の$_SESSIONをクリア
session_destroy();
// サインアウトしたあとの遷移
header('location: index.php');
exit();


?>