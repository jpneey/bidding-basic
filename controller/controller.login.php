<?php

require_once 'controller.auth.php';
require_once 'controller.sanitizer.php';
require_once 'controller.database.php';

$auth = new Auth();
$dbhandle = new DBHandler();
$connection = $dbhandle->connectDB();

$isLoggedIn = $auth->compareSession('auth', true);
$mode = isset($_GET['mode']) ? $_GET['mode'] : 'none'; 

$code = '1';
$message = 'Undefined Mode';

$_SESSION['attempts'] = isset($_SESSION['attempts']) ? $_SESSION['attempts'] : 0;
$_SESSION['attempts']++;

if($_SESSION['attempts'] >= '10'){
    $code = '1';
    $message = 'You are doing this action way too often. Please try again later.';
    $mode = 'default';
}

switch($mode) {

    case 'login':

        $userEmail = Sanitizer::filter('cs_ems', 'post', 'email');
        $userPassword = Sanitizer::filter('cs_pas', 'post');
        $stmt = $connection->prepare("SELECT * FROM cs_users WHERE cs_user_email = ? LIMIT 1");
        
        $stmt->bind_param('s', $userEmail);
        $stmt->execute();
        $account = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
    
        $code = '1';
        $message = 'Account not found';    
    
        if(!empty($account)){
            if(password_verify($userPassword, $account[0]['cs_user_password'])){
                $code = '0';
                $message = 'Success';
                $auth->setSession('auth', true);
                $auth->setSession('__user_id', (int)$account[0]["cs_user_id"]);
                $auth->setSession('__user_role', (int)$account[0]["cs_user_role"]);
            } else {
                $code = '1';
                $message = 'Invalid login credentials';
            }
        }

        break;

    case 'register':
        $userEmail = Sanitizer::filter('cs_ems', 'post', 'email');
        $stmt = $connection->prepare("SELECT * FROM cs_users WHERE cs_user_email = ? LIMIT 1");
        $stmt->bind_param('s', $userEmail);
        $stmt->execute();
        $account = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $stmt->close();

        if(!empty($account)){
            echo json_encode(array('code' => '1', 'message' => 'This email address is already used. Please try logging in or request a password reset if needed.'));
            die();
        }
    
        require 'mail/mail.php';

        $password = Sanitizer::generatePassword();

        $temporaryPassword = password_hash($password, PASSWORD_BCRYPT);
        $mail->AddAddress($userEmail);
        
        $emailSubject = "Canvasspoint Registration";   //subject
        $emailPreheader = "Verify your email address and maximize your canvasspoint experience."; //short message
        $emailGreeting = "Hooray !";
        $emailContent = "Your canvasspoint journey is about to start! Click the button below to set up your account.";
        $emailAction = Sanitizer::getUrl()."verify/?e=".urlencode($userEmail)."&token=".urlencode($temporaryPassword)."&p=".$password;    //link
        $emailActionText = "Setup Account";
        $emailFooterContent = "Your temporary password is: <b>$password</b>. You can change your password later when you start setting up your account.";
        $emailRegards = "- Canvasspoint Team";
        
        
        ob_start();
        require 'mail/template/basic.php';
        $htmlMessage = ob_get_contents();
        ob_end_clean(); 
        
        
        $mail->Subject = $emailSubject;
        $mail->Body = $htmlMessage;

        $code = '11';
        $message = 'An email confirmation was sent to: '.$userEmail. "";   
        
        if(!$mail->Send()) {
            $code = '1';
            $message = 'We are unable to reach '.$userEmail. " :(".$mail->ErrorInfo;   
        }
        break;

    case 'forgot':
        $userEmail = Sanitizer::filter('cs_ems', 'post', 'email');
        $stmt = $connection->prepare("SELECT cs_user_password FROM cs_users WHERE cs_user_email = ? LIMIT 1");
        $stmt->bind_param('s', $userEmail);
        $stmt->execute();
        $account = $stmt->get_result()->fetch_row();
        $stmt->close();

        if(empty($account)){
            echo json_encode(array('code' => '1', 'message' => 'We can\'t find an account associated with the given email.'));
            die();
        }
    
        require 'mail/mail.php';

        $temporaryPassword = $account[0];
        $mail->AddAddress($userEmail);
        
        $emailSubject = "Password reset";   //subject
        $emailPreheader = "Someone requested a password reset for your canvasspoint account."; //short message
        $emailGreeting = "Hey there, ";
        $emailContent = "Someone requested a password reset for your canvasspoint account. If it was you, you are just a click away! Please click the button below to reset you password.";
        $emailAction = Sanitizer::getUrl()."password-reset/?e=".urlencode($userEmail)."&token=".urlencode($temporaryPassword);    //link
        $emailActionText = "Reset Password";
        $emailFooterContent = "Ignore this email if it is not you who requested a password reset. Your account is safe.";
        $emailRegards = "- Canvasspoint Team";
        
        
        ob_start();
        require 'mail/template/basic.php';
        $htmlMessage = ob_get_contents();
        ob_end_clean(); 
        
        
        $mail->Subject = $emailSubject;
        $mail->Body = $htmlMessage;

        $code = '1';
        $message = 'Password reset link was sent to: '.$userEmail. "";   
        
        if(!$mail->Send()) {
            $code = '1';
            $message = 'We are unable to reach '.$userEmail. " :(";   
        }
        break;

}

echo json_encode(array('code' => $code, 'message' => $message));
