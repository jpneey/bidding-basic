<?php

require_once "./app/controller/controller.auth.php";
require_once "./app/controller/controller.utility.php";

$auth = new Auth();
$BASE = Utility::getBase();
$BASE_DIR = Utility::getBase(false);

$auth->sessionDie($BASE_DIR."login/");
die();
