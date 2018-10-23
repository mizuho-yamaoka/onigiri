<?php
session_start();
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// PHPMailerを配置するパスを自身の環境に合わせて修正
require '../PHPMailer-master/src/Exception.php';
require '../PHPMailer-master/src/PHPMailer.php';
require '../PHPMailer-master/src/SMTP.php';


if(!empty($_GET)){
  $joiner_email = $_GET['joiner_email'];
  $poster_email = $_GET['poster_email'];
  $feed_id = $_GET['feed_id'];
}


$mail = new PHPMailer(true);                              // Passing `true` enables exceptions
try {
    //Server settings
    $mail->SMTPDebug = 2;                                 // Enable verbose debug output
    $mail->isSMTP();                                      // Set mailer to use SMTP
    $mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
    $mail->SMTPAuth = true;                               // Enable SMTP authentication
    $mail->Username = 'yume1nose@gmail.com';                 // SMTP username
    $mail->Password = 'swim3838';                           // SMTP password
    $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
    $mail->Port = 587;                                    // TCP port to connect to (ssl:465)

    //Recipients
    $mail->setFrom($joiner_email, 'CEBUFULL');

    $mail->addAddress($poster_email, 'DEAR CEBUFULL USER');     // Add a recipient


    // //Attachments
    // $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
    // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

    //Content
    $mail->isHTML(true);                                  // Set email format to HTML
    $mail->Subject = 'CEBUFULL BBS INFO';
    $mail->Body    = 'You got participants for your activity!! Plese contact to participants e-mail adress ' . $joiner_email . '.';
    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    $mail->send();
   
   header('Location: bbs.php?sent="SENT"');
   $_SESSION['feed_id'] = $feed_id;
   exit();

    // echo 'Message has been sent';
} catch (Exception $e) {
    echo 'Message could not be sent. Mailer Error: ';
    // $mail->ErrorInfo;
}
?>


