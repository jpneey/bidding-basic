<?php 

require_once "../controller.auth.php";
require_once "../controller.sanitizer.php";
require_once "../controller.db.php";
require_once "../../model/model.location.php";


$auth = new Auth();
$db = new DBHandler();
$connection = $db->connectDB();
$location = new Location();

$mode = Sanitizer::filter('mode', 'get');


$isLoggedIn = $auth->getSession('admin_auth');
if(!$isLoggedIn) { die();}

switch($mode) {
    case 'add':
        $loc = Sanitizer::filter('name', 'post');
        if(!$loc) {
            echo json_encode(array('code' => 0, 'message' => "Location name can't be empty"));
            die();
        }
        $location->postLocation($loc);
        $code = 2;
        $message = "Location Added";
        break;

    case 'update':
        $loc = Sanitizer::filter('name', 'post');
        $id = Sanitizer::filter('id', 'get', 'int');
        if(!$loc) {
            echo json_encode(array('code' => 0, 'message' => "Location name can't be empty"));
            die();
        }
        $location->updateLocation($id, $loc);
        $code = 2;
        $message = "Location Updated";
        break;

    default:
        $code = 0;
        $message = "Bad Request";
}


echo json_encode(array('code' => $code, 'message' => $message));
