<?php

use PHPMailer\PHPMailer\PHPMailer;

require 'Exception.php';
require 'PHPMailer.php';
require 'SMTP.php';

$mail = new PHPMailer();
$mail->IsSMTP();
$mail->SMTPDebug = 0;
$mail->SMTPAuth = true;
$mail->SMTPSecure = 'ssl';
$mail->Host = "smtp.gmail.com";
$mail->Port = 465;
$mail->IsHTML(true);
$mail->Username = "pmcmailchimp@gmail.com";
$mail->Password = "1_pmcmailchimp@gmail.com";
$mail->SetFrom("pmcmailchimp@gmail.com", "John Paul");
$mail->isHTML(true);