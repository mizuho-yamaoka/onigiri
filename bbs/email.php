<?php
mb_language("English");
mb_internal_encoding("UTF-8");

if(!empty($_GET['joiner_email'])){

$joiner_email = $_GET['joiner_email'];
$poster_email = $_GET['poster_email'];
  // echo '<pre>';
  // var_dump($poster_email);
  // echo '</pre>';

  $to = $poster_email;
  $title = 'CEBUFULL BBS INFO';
  $content = 'hello';
  // $content = 'We found a participant who want to join your activity!! Please, send e-mail to' . $joiner_email . ' and discuss about activity!!';

  if(mb_send_mail($to, $title, $content)){
  echo '成功';
  }else{
    echo '失敗';
  }

  // $_SESSION['email'] = 'SENT';
  // header('Location: email_form.php');
  // exit();

}
