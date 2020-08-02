<?php

require_once "include/include.import.php";

$connection = $dbhandler->connectDB();

if($auth->compareSession('auth', true)){
    header("location: ".$BASE_DIR."home/?unauth=1");
    die();
}

$emailAddress = urldecode(Sanitizer::filter('e', 'get'));
$temporaryPassword = urldecode(Sanitizer::filter('token', 'get'));
$userName = strtok($emailAddress, '@');

if(!password_verify('00'.$emailAddress.'cpoint', $temporaryPassword)) {
    header("location: ".$BASE_DIR."home/?unauth=1");
    die();
}

$stmt = $connection->prepare("SELECT cs_user_id FROM cs_users WHERE cs_user_email = ? AND cs_user_password = ? AND cs_user_role = 0");
$stmt->bind_param('ss', $emailAddress, $temporaryPassword);
$stmt->execute();
$result = $stmt->get_result()->fetch_row();
$stmt->close();

if(!empty($result)){
        
    $auth->setSession('auth', true);
    $auth->setSession('__user_id', $result[0]);
    $auth->setSession('__user_role', 0);

    $setup_link = $BASE_DIR."my/account/?p=t&t=".urlencode($temporaryPassword)."&u=".$result[0]."&existed=true";
    header("location: ".$setup_link);
    die("<a href='$setup_link'>Please click here if you are not redirected automatically.</a>");

}

$stmt = $connection->prepare("INSERT INTO cs_users(cs_user_name, cs_user_email, cs_user_password, cs_user_role, cs_user_avatar) VALUES(?, ?, ?, 0, 'avatar.png')");
$stmt->bind_param('sss', $userName, $emailAddress, $temporaryPassword);
$stmt->execute();
$created_id = $stmt->insert_id;
$stmt->close();


$auth->setSession('auth', true);
$auth->setSession('__user_id', $created_id);
$auth->setSession('__user_role', 0);

$setup_link = $BASE_DIR."my/account/?p=t&t=".urlencode($temporaryPassword)."&u=".$created_id;

header("location: ".$setup_link);
die("<a href='$setup_link'>Please click here if you are not redirected automatically.</a>");

// EOF


// http://localhost/bidding-basic/my/account/?p=t&t=%242y%2410%24X2t8MNNi%2FtbtEJp7PUagFORpR8ut%2F8rLfd.jQ3Mt2VwyeLQPknXUG&u=5

// http://localhost/bidding-basic/verify/?e=burato348%40gmail.com&token=%242y%2410%24X2t8MNNi%2FtbtEJp7PUagFORpR8ut%2F8rLfd.jQ3Mt2VwyeLQPknXUG

// http://localhost/bidding-basic/my/account/?p=t&t=%242y%2410%24X2t8MNNi%2FtbtEJp7PUagFORpR8ut%2F8rLfd.jQ3Mt2VwyeLQPknXUG&u=5&existed=true