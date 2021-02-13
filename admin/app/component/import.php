<?php

    require_once "./app/controller/controller.auth.php";
    require_once "./app/controller/controller.utility.php";
    require_once "./app/controller/controller.db.php";
    require_once "./app/model/model.user.php";

    $auth = new Auth();
    $user = new User();
    $dbhandle = new DBHandler();
    
    $BASE = Utility::getBase();
    $BASE_DIR = Utility::getBase(false);

    $isLoggedIn = $auth->getSession('admin_auth');

    if(!$isLoggedIn) { header("location: ".$BASE_DIR."login/");}

    $loggedInRole = $auth->getSession('admin_role');
    $loggedInRoleString = Utility::getRoleString($loggedInRole);
    $loggedInName = str_replace("_", " ", $auth->getSession('admin_name'));

    $isMarketing = ($loggedInRole == 3) ? true : false;
    $isAdmin = ($loggedInRole == 5) ? true : false;
    $isHr = ($loggedInRole == 2) ? true : false;
