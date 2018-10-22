<?php
// mb_language("English");
mb_internal_encoding("UTF-8");

if(!empty($_GET['joiner_email'])){

$joiner_email = $_GET['joiner_email'];
$poster_email = $_GET['poster_email'];


  $to = $poster_email;
  $title = 'CEBUFULL BBS INFO';
  $content = 'hello';
  $sender = $joiner_email;
  // $content = 'We found a participant who want to join your activity!! Please, send e-mail to' . $joiner_email . ' and discuss about activity!!';

  mail($to, $title, $content,$sender);


  // $_SESSION['email'] = 'SENT';
  // header('Location: email_form.php');
  // exit();

}


