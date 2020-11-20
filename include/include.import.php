<?php

date_default_timezone_set('Asia/Manila');
require_once "controller/controller.auth.php";
require_once "controller/controller.sanitizer.php";
require_once "controller/controller.database.php";
require_once "model/model.user.php";
require_once "model/model.constant.php";

$dbhandler = new DBHandler();

$conn = $dbhandler->connectDB();

$user = new User($conn);

$auth = new Auth();
$__user_id = 0;
$loggedInUserRole = 'Guest';

$isLoggedIn = $auth->compareSession('auth', true);
$isBidder = false;
$isSupplier = false;

$loggedInAccountType = $loggedInUserAvatar = $loggedInUserName = $loggedInUserEmail = '';

if($isLoggedIn){
    $__user_id   = (int)$auth->getSession('__user_id');
    $loggedInUserRole = (int)$auth->getSession('__user_role');
    $__user = $user->getUser($__user_id);
    
    $loggedInUserName = $__user[0]["cs_user_name"];
    $loggedInUserEmail = $__user[0]["cs_user_email"];
    $loggedInUserAvatar = $__user[0]["cs_user_avatar"];
    $loggedInAccountType = $__user[0]["cs_plan_id"];
    $isBidder =($loggedInUserRole == '1') ? true : false;
    $isSupplier =($loggedInUserRole == '2') ? true : false;

}


define('included', true);
$uri = explode("/", $_SERVER["QUERY_STRING"]);
$BASE_DIR = Sanitizer::getUrl();