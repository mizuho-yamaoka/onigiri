<?php
    $url = parse_url(getenv("CLEARDB_DATABASE_URL"));

    $dsn = 'mysql:dbname=laguardia_cebufull;host=mysql7036.xserver.jp';
    $user = 'laguardia_lechon';
    $password= 'e35vzezr';
    $dbh = new PDO($dsn, $user, $password);
    // SQL文にエラーがあった際、画面にエラーを出力する設定
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $dbh->query('SET NAMES utf8');
?>