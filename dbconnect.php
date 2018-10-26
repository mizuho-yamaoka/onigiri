<?php
    $url = parse_url(getenv("CLEARDB_DATABASE_URL"));

    $dsn = 'mysql:dbname' . substr($url['path'],1) . ';host=' . $url['host'];
    $user = $url['user'];
    $password= $url['pass'];
    $dbh = new PDO($dsn, $user, $password);
    // SQL文にエラーがあった際、画面にエラーを出力する設定
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $dbh->query('SET NAMES utf8');
?>