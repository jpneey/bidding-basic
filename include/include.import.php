<?php

require_once "controller/controller.auth.php";
require_once "controller/controller.filevalidator.php";
require_once "controller/controller.sanitizer.php";
require_once "controller/controller.database.php";
require_once "model/model.user.php";
require_once "model/model.bidding.php";
require_once "model/model.constant.php";

$auth = new Auth();
$dbhandler = new DBHandler();
$user = new User();
$bid = new Bids();

$__user_id = 0;
$loggedInUserRole = 'Guest';
$isBidder = false;

$isLoggedIn = $auth->compareSession('auth', true);
if($isLoggedIn){
    $__user_id   = (int)$auth->getSession('__user_id');
    $loggedInUserRole = (int)$auth->getSession('__user_role');
    $loggedInUserName = $user->getUser($__user_id, "cs_user_name");
    $loggedInUserEmail = $user->getUser($__user_id, "cs_user_email");
    $loggedInUserAvatar = $user->getUser($__user_id, "cs_user_avatar");
    $isBidder =($loggedInUserRole == '1') ? true : false;
}

define('included', true);
$uri = explode("/", $_SERVER["QUERY_STRING"]);
$BASE_DIR = '/bidding-basic/';