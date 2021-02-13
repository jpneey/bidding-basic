<?php 

require_once "../controller.auth.php";
require_once "../controller.sanitizer.php";
require_once "../controller.db.php";
require_once "../../model/model.user.php";


$auth = new Auth();
$db = new DBHandler();
$connection = $db->connectDB();
$user = new User();

$mode = Sanitizer::filter('mode', 'get');


$isLoggedIn = $auth->getSession('admin_auth');
if(!$isLoggedIn) { die();}

switch($mode) {
    case 'viewable':
        $id = Sanitizer::filter('id', 'get');
        $value = Sanitizer::filter('value', 'get');
        $user->viewable($id, $value);
        $code = 2;
        $message = "Data Updated";
        break;
        
    case 'status':
        $id = Sanitizer::filter('id', 'get');
        $value = Sanitizer::filter('value', 'get');
        $user->status($id, $value);
        $code = 2;
        $message = "Status Updated";
        break;

    default:
        $code = 0;
        $message = "Bad Request";
}


echo json_encode(array('code' => $code, 'message' => $message));
