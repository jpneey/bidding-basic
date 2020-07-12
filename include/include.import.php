<?php

require_once "controller/controller.auth.php";
require_once "controller/controller.db.php";

$auth = new Auth();
$dbcontroller = new DBController();

$__user_id = 0;
$__user_role = 0;

$isLoggedIn = $auth->compareSession('auth', true);
if($isLoggedIn){
    $__user_id   = (int)$auth->getSession('__user_id');
    $__user_role = (int)$auth->getSession('__user_role');
}

$uri = explode("/", $_SERVER["QUERY_STRING"]);
$BASE_DIR = 'http://localhost/bidding-basic/';
$variable = "Hello I'am a variable defined from <code>include/include.import.php</code>";