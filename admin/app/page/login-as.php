<?php

require_once "./app/controller/controller.auth.php";
require_once "./app/controller/controller.utility.php";
require_once "./app/controller/controller.sanitizer.php";

$auth = new Auth();
$BASE = Utility::getBase();
$BASE_DIR = Utility::getBase(false);

$id= Sanitizer::filter('token', 'get');
$role= Sanitizer::filter('mod', 'get');

$isLoggedIn = $auth->getSession('admin_auth');

if(!$isLoggedIn) { header("location: ".$BASE_DIR."login/");}
if(!$id) { header("location: ".$BASE_DIR."id/");}
if(!$role) { header("location: ".$BASE_DIR."role/");}

$auth->setSession('admin_auth', false);
$auth->setSession('auth', true);
$auth->setSession('__user_id', (int)$id);
$auth->setSession('__user_role', (int)$role);

?>

<script>window.location.replace("http://jpburato.epizy.com")</script>
