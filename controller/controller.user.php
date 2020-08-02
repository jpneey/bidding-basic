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
$action = Sanitizer::filter('action', 'get');

if(!$auth->compareSession('auth', true)){
    echo json_encode(array('code' => 0, 'message' => 'Oh no! You need to login to perform this action.'));
    die();
}

$__user_id = (int)$auth->getSession('__user_id');

switch ($action) {

    case 'update':

        $safeImage = '#!';
        $uploaded = false;

        $stmt = $connection->prepare("SELECT cs_user_avatar FROM cs_users WHERE cs_user_id = '$__user_id'");
        $stmt->execute();
        $result = $stmt->get_result()->fetch_row();
        $stmt->close();

        $current_avatar = ($result[0] != 'avatar.png') ? $result[0] : '#!';

        if (
            FileValidator::isUploaded('cs_user_avatar') &&
            FileValidator::allowedSize('cs_user_avatar', 3000000) &&
            FileValidator::allowedType('cs_user_avatar', array('jpg', 'png', 'jpeg', 'gif'))
        ) {
            $directory = '../static/asset/user/';
            $safeImage = FileValidator::rename('jp', 'cs_user_avatar');

            if (!FileValidator::upload($directory, 'cs_user_avatar', $safeImage)) {
                $message = "File Upload(".$safeImage.") failed!";
                echo json_encode(array('code' => 0, 'message' => $message));
                exit();
            }
            unlink($dbhandler.$current_avatar);
        }

        $cs_user_name = Sanitizer::filter('cs_user_name', 'post');

        $binds = 'ss';
        $values = array($cs_user_name, $safeImage);

        break;
}

echo $message;