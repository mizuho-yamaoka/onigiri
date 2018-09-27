<?php 
// DBを操作する共通ファイル
// data source name
$dsn = 'mysql:dbname=Cebufull;host=localhost';
// ユーザー名
$user = 'root';
// パスワード
$password = '';
// database handle
$dbh = new PDO($dsn,$user,$password);
// 
$dbh -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$dbh->query('SET NAMES utf8');