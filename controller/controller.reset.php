<?php

require_once "./controller.auth.php";
require_once "./controller.sanitizer.php";
require_once "./controller.database.php";
require_once "./controller.filevalidator.php";
require_once "../model/model.user.php";
require_once "../model/model.constant.php";

$auth = new Auth();
$dbhandler = new DBHandler();
$user = new User();

$connection = $dbhandler->connectDB();

$cs_user_email = Sanitizer::filter('em', 'post');
$cs_user_password = Sanitizer::filter('token', 'post');

$cs_new_password = Sanitizer::filter('cs_new_password', 'post');
$cs_confirm_password = Sanitizer::filter('cs_confirm_password', 'post');

if($cs_new_password !== $cs_confirm_password) {
    echo json_encode(array('code' => 0, 'message' => 'Password confirmation mismatch.'));
    die();
}

$stmt = $connection->prepare("SELECT cs_user_id FROM cs_users WHERE cs_user_email = ? AND cs_user_password = ?");
$stmt->bind_param("ss", $cs_user_email, $cs_user_password);
$stmt->execute();
$result = $stmt->get_result()->fetch_row();
$stmt->close();

if(empty($result)) {
    echo json_encode(array('code' => 0, 'message' => 'Password reset link expired.'));
    die();
}


$newPassword = password_hash($cs_new_password, PASSWORD_BCRYPT);

$stmt = $connection->prepare("UPDATE cs_users SET cs_user_password = ? WHERE cs_user_id = ?");
$stmt->bind_param("si", $newPassword, $result[0]);
$stmt->execute();
$stmt->close();

echo json_encode(array('code' => 0, 'message' => 'Password updated. You can now login.'));