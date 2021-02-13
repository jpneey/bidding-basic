<?php 

require_once "../controller.auth.php";
require_once "../controller.sanitizer.php";
require_once "../controller.db.php";

$auth = new Auth();
$db = new DBHandler();
$connection = $db->connectDB();
$mode = Sanitizer::filter('mode', 'get');

switch($mode) {
    case 'login':
    
        $userName = Sanitizer::filter('user_name', 'post', 'email');
        $userPassword = Sanitizer::filter('user_password', 'post');
        $stmt = $connection->prepare("SELECT cs_admin_user, cs_admin_password, cs_admin_role FROM cs_admin WHERE cs_admin_user = ? LIMIT 1");
        
        $stmt->bind_param('s', $userName);
        $stmt->execute();
        $account = $stmt->get_result()->fetch_row();
        $stmt->close();
    
        $code = 0;
        $message = 'Account not found';    
    
        if(!empty($account)){
            if(password_verify($userPassword, $account[1])){
                $code = 3;
                $message = 'Success';
                $auth->setSession('admin_auth', true);
                $auth->setSession('admin_role', $account[2]);
                $auth->setSession('admin_name', $account[0]);
            } else {
                $code = 0;
                $message = 'Invalid login credentials';
            }
        }

        break;
}


echo json_encode(array('code' => $code, 'message' => $message));
