<?php

require_once 'controller.auth.php';
require_once 'controller.db.php';
require_once 'controller.sanitizer.php';

$auth = new Auth();
$dbhandle = new DBController();

$isLoggedIn = $auth->compareSession('auth', true);
$mode = isset($_GET['mode']) ? $_GET['mode'] : 'none'; 

switch($mode) {

    case 'login':
        $userEmail = Sanitizer::filter('cs_ems', 'post', 'email');
        $userPassword = Sanitizer::filter('cs_pas', 'post');
        $account = $dbhandle->runQuery("SELECT * FROM cs_users WHERE cs_user_email = '$userEmail' AND cs_user_password = '$userPassword' LIMIT 1");
        if(!empty($account)){
            $data = '0';
            $message = 'Success';
            $auth->setSession('auth', true);
            $auth->setSession('__user_id', (int)$account[0]["cs_user_id"]);
            $auth->setSession('__user_role', (int)$account[0]["cs_user_role"]);
        } else {
            $data = '1';
            $message = 'Account not found';    
        }
        break;
    default:
        $data = '1';
        $message = 'Undefined Mode';    
        
}

echo json_encode(array('code' => $data, 'message' => $message));
