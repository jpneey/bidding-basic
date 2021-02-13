<?php

require_once "../controller.sanitizer.php";
require_once "../controller.utility.php";
require_once "../controller.filevalidator.php";
require_once "../controller.imageoptimizer.php";
require_once "../controller.auth.php";


$auth = new Auth();
$mode = Sanitizer::filter('mode', 'get');
$filecleaner = new FileValidator();

$isLoggedIn = $auth->getSession('admin_auth');
if(!$isLoggedIn) { die();}

if(!$auth->getSession("admin_auth") || !in_array($auth->getSession("admin_role"), array(5,3))) {
    echo json_encode(array("code" => 0, "message" => "You are unauthorized to perform this action"));
    exit();
}

$error = array();

switch($mode) {
    
    case "add":

        if(!FileValidator::validateImage('image', 3000000, array('jpg', 'png', 'jpeg', 'gif'), 'jpg', '../../static/upload/', true)) {
            $error[] = "Upload failed. File size must be less then 3mb with 'jpg', 'png', 'jpeg' or 'gif' file extension. ";
        }

        if(!empty($error)) { echo json_encode(array("code" => 0, "message" => implode(', ', $error))); exit(); }

        $response = json_encode(array("code" => 3, "message" => "Upload complete"));
        break;

    default:
        $response = json_encode(array("code" => 0, "message" => "Sorry we can't find what you're looking for."));
        
}

echo $response;

