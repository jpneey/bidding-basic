<?php

require_once "include/include.import.php";

$connection = $dbhandler->connectDB();

if($auth->compareSession('auth', true)){
    header("location: ".$BASE_DIR."home/?unauth=1");
    die();
}

$emailAddress = urldecode(Sanitizer::filter('e', 'get'));
$temporaryPassword = urldecode(Sanitizer::filter('token', 'get'));
$p = urldecode(Sanitizer::filter('p', 'get'));
$userName = 'user-'.$emailAddress;

$stmt = $connection->prepare("SELECT cs_user_id FROM cs_users WHERE cs_user_email = ? AND cs_user_password = ? AND cs_user_role = 0");
$stmt->bind_param('ss', $emailAddress, $temporaryPassword);
$stmt->execute();
$result = $stmt->get_result()->fetch_row();
$stmt->close();

if(!empty($result)){
        
    $auth->setSession('auth', true);
    $auth->setSession('__user_id', $result[0]);
    $auth->setSession('__user_role', 0);

    $setup_link = $BASE_DIR."my/account/?p=t&u=".$result[0]."&existed=true&pw=".$p;
    header("location: ".$setup_link);
    die("<a href='$setup_link'>Please click here if you are not redirected automatically.</a>");

}


$stmt = $connection->prepare("SELECT cs_user_id FROM cs_users WHERE cs_user_email = ?");
$stmt->bind_param('s', $emailAddress);
$stmt->execute();
$result = $stmt->get_result()->fetch_row();
$stmt->close();

if(!empty($result)) {
    header("location: ".$BASE_DIR."home/?m=bad-request");
    die();
}

$stmt = $connection->prepare("INSERT INTO cs_users(cs_user_name, cs_user_email, cs_user_password, cs_user_role, cs_user_avatar) VALUES(?, ?, ?, 0, 'avatar.png')");
$stmt->bind_param('sss', $userName, $emailAddress, $temporaryPassword);
$stmt->execute();
$created_id = $stmt->insert_id;
$stmt->close();


$auth->setSession('auth', true);
$auth->setSession('__user_id', $created_id);
$auth->setSession('__user_role', 0);

$setup_link = $BASE_DIR."my/account/?p=t&u=".$created_id."&pw=".$p;

header("location: ".$setup_link);
die("<a href='$setup_link'>Please click here if you are not redirected automatically.</a>");

// EOF

