<?php

require_once 'controller.auth.php';
require_once 'controller.database.php';
require_once 'controller.sanitizer.php';

$auth = new Auth();
$dbhandle = new DBHandler();
$connection = $dbhandle->connectDB();

$isLoggedIn = $auth->compareSession('auth', true);
$mode = isset($_GET['mode']) ? $_GET['mode'] : 'none'; 

$code = '1';
$message = 'Undefined Mode';

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

}

echo json_encode(array('code' => $code, 'message' => $message));
