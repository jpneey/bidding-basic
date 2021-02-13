<?php 

require_once "../controller.auth.php";
require_once "../controller.sanitizer.php";
require_once "../controller.db.php";
require_once "../../model/model.maintenance.php";


$auth = new Auth();
$db = new DBHandler();
$connection = $db->connectDB();
$maintenance = new Maintenance();

$mode = Sanitizer::filter('mode', 'get');


$isLoggedIn = $auth->getSession('admin_auth');
if(!$isLoggedIn) { die();}

switch($mode) {

        
    case 'email':
        $required = array('em');
        foreach($required as $field) { ${$field} = Sanitizer::filter($field, 'post'); }
        $maintenance->updateAdminEmail($em);
        $code = 2;
        $message = "Email Updated ";
        break;
        
    case 'home':
        $required = array('a', 'b', 'c', 'd');
        foreach($required as $field) { ${$field} = (int)Sanitizer::filter($field, 'post', 'int'); }
        $str = $a.",".$b.",".$c.",".$d;
        $maintenance->updateHomeData($str);
        $code = 2;
        $message = "Data Updated ";
        break;

    default:
        $code = 0;
        $message = "Bad Request";
}


echo json_encode(array('code' => $code, 'message' => $message));
