<?php
include('config.php');
require 'lib/php-mailer/PHPMailerAutoload.php';

function add_to_subscr($email_to = '', $text = '', $subject = ''){
      global $db; global $username; global $password;
      try{
            if($email_to == '' || $text == '') return false;
            $dbd = new PDO("mysql:host=$server;charset=cp1251;dbname=$db", $username, $password);
            //$dbd->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
            $query = $dbd->prepare('INSERT INTO email_subsc (email_to, text, subject) values(:email_to, :text, :subject)');
            $query->bindParam(':email_to', $email_to);
            $query->bindParam(':text', $text);
            $query->bindParam(':subject', $subject);
            $res = $query->execute();
            return $res;
      }catch(PDOException $e) {
            //echo $e->getMessage();
            return false;
      }
}

function email_smtp($to, $message, $subject) {
      global $fromEmail, $pass, $company;
      $mail = new PHPMailer;
      $mail->CharSet = "windows-1251";
      $mail->From = $fromEmail;
      $mail->FromName = $company;
      $mail->isHTML(true);
      $mail->Subject = $subject;
      $mail->Body    = $message;

      $mail->isSMTP();
      $mail->Host = 'smtp.yandex.ru';  // Specify main and backup SMTP servers
      $mail->SMTPAuth = true;                               // Enable SMTP authentication
      $mail->Username = $fromEmail;                 // SMTP username
      $mail->Password = $pass;                           // SMTP password
      $mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
      $mail->Port = 465;                                    // TCP port to connect to

      if (is_array($to)) {
            foreach ($to as $toItem) {
                  $mail->addAddress($toItem);
            }
      } else {
            $mail->addAddress($to);
      }

      $res =  $mail->send();

      return ($res) ? $res : email($to, $message, $subject);
}

function email($to, $message, $subject){
      $mail = new PHPMailer;
      $mail->CharSet = "windows-1251";
      $mail->From = 'noreply@igry-pochemuchek.ru';
      $mail->FromName = 'Игры почемучек';
      if (is_array($to)) {
            foreach ($to as $toItem) {
                  $mail->addAddress($toItem);
            }
      } else {
            $mail->addAddress($to);
      }
      $mail->isHTML(true);
      $mail->Subject = $subject;
      $mail->Body    = $message;
      $res =  $mail->send();
    return $res;
}
?>