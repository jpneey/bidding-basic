<?php

require_once "controller/controller.auth.php";
require_once "controller/controller.db.php";
require_once "model/model.user.php";
require_once "model/model.render.php";
require_once "model/model.bidding.php";

$auth = new Auth();
$dbhandle = new DBController();
$user = new User();
$render = new Render();
$bid = new Bids();

$__user_id = 0;
$loggedInUserRole = 'Guest';

$isLoggedIn = $auth->compareSession('auth', true);
if($isLoggedIn){
    $__user_id   = (int)$auth->getSession('__user_id');
    $loggedInUserRole = (int)$auth->getSession('__user_role');
    $loggedInUserName = $user->getUser($__user_id, "cs_user_name");
    $loggedInUserAvatar = $user->getUser($__user_id, "cs_user_avatar");
}

$uri = explode("/", $_SERVER["QUERY_STRING"]);
$BASE_DIR = 'http://localhost/bidding-basic/';