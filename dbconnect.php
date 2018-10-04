<?php
    $dsn = 'mysql:dbname=CEBUFULL;host=localhost';
    $name = 'root';
    $password='';
    $dbh = new PDO($dsn, $name, $password);
    // SQL文にエラーがあった際、画面にエラーを出力する設定
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $dbh->query('SET NAMES utf8');
?>