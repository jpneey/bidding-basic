<?php

require 'mail/mail.php';

$mail->AddAddress('burato348@gmail.com');

$emailSubject = "Output Buffering";   //subject
$emailPreheader = "You need to use a PHP feature called output buffering."; //short message
$emailGreeting = "Hello JP,";
$emailContent = "When a form is submitted to a PHP script, the information from that form is automatically made available to the script. There are few ways to access this information, for example";
$emailAction = "https://google.com";    //link
$emailActionText = "Google's site";
$emailFooterContent = "I learned something cool today! ";
$emailRegards = "John Paul";


ob_start();
require 'mail/template/basic.php';
$htmlMessage = ob_get_contents();
ob_end_clean(); 


$mail->Subject = $emailSubject;
$mail->Body = $htmlMessage;

if(!$mail->Send()) {
    exit("Mail not sent");
}

echo 'Mail sent';