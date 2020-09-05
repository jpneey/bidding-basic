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
$__user_role = (int)$auth->getSession('__user_role');

switch ($action) {

    case 'update':
        
        $cs_user_name = Sanitizer::filter('cs_user_name', 'post');
        $cs_user_name = Sanitizer::url($cs_user_name);
        $cs_user_password = Sanitizer::filter('cs_user_password', 'post');
        $cs_new_password = Sanitizer::filter('cs_new_password', 'post');
        $cs_user_detail = Sanitizer::filter('cs_user_detail', 'post');

        $stmt = $connection->prepare("SELECT cs_user_avatar, cs_user_password FROM cs_users WHERE cs_user_id = '$__user_id'");
        $stmt->execute();
        $result = $stmt->get_result()->fetch_row();
        $stmt->close();
        
        $safeImage = NULL;
        $current_avatar = ($result[0] != 'avatar.png') ? $result[0] : '#!';

        if(!password_verify($cs_user_password, $result[1])){
            echo json_encode(array('code' => 0, 'message' => 'Your password is incorrect. Failed to authenticate.'));
            die();
        }

        if (
            FileValidator::isUploaded('cs_user_avatar') &&
            FileValidator::allowedSize('cs_user_avatar', 3000000) &&
            FileValidator::allowedType('cs_user_avatar', array('jpg', 'png', 'jpeg', 'gif'))
        ) {
            $directory = '../static/asset/user/';
            $safeImage = FileValidator::rename('jp', 'cs_user_avatar');
            
            if(file_exists($directory.$current_avatar)){
                unlink($directory.$current_avatar);
            }
            if (!FileValidator::upload($directory, 'cs_user_avatar', $safeImage)) {
                $message = "File Upload(".$safeImage.") failed! Operation Cancelled.";
                echo json_encode(array('code' => 0, 'message' => $message));
                die();
            }
        }

        if(!empty($cs_user_name)){
            if(!$user->updateUserCol($__user_id, 'cs_user_name', 's', $cs_user_name, true)){
                echo json_encode(array('code' => 0, 'message' => 'Failed to update username. Username already exists'));
                die();
            }
        }

        if(!empty($cs_user_detail)){
            if(!$user->updateUserCol($__user_id, 'cs_user_detail', 's', $cs_user_detail)){
                echo json_encode(array('code' => 0, 'message' => 'Failed to update username.'));
                die();
            }
        }

        if(!empty($safeImage)){
            if(!$user->updateUserCol($__user_id, 'cs_user_avatar', 's', $safeImage)){
                echo json_encode(array('code' => 0, 'message' => 'Failed to update your avatar.'));
                die();
            }
        }

        if(!empty($cs_new_password)){
            $cs_new_password = password_hash($cs_new_password, PASSWORD_BCRYPT);
            if(!$user->updateUserCol($__user_id, 'cs_user_password', 's', $cs_new_password)){
                echo json_encode(array('code' => 0, 'message' => 'Failed to update your password.'));
                die();
            }
        }

        if(empty($__user_role)) {
            $cs_user_role = Sanitizer::filter('account-type', 'post', 'int');
            if(!in_array($cs_user_role, array('1', '2'))){
                echo json_encode(array('code' => 0, 'message' => 'We can\'t create an account using the selected account type. Please refresh the page and try again.'));
                die();
            }
            if(!$user->updateUserCol($__user_id, 'cs_user_role', 'i', $cs_user_role)){
                echo json_encode(array('code' => 0, 'message' => 'Failed to update your user role.'));
                die();
            }
            $auth->setSession('__user_role', (int)$cs_user_role);    
        }

        $message = json_encode(array('code' => 1, 'message' => 'Action Complete'));
        break;

    case 'update-contact':

        $posts = array(
            'cs_facebook',
            'cs_linkedin',
            'cs_website',
            'cs_telephone',
            'cs_mobile'
        );

        $contactArray = array();

        foreach($posts as $post){
            ${$post} = (Sanitizer::filter($post, 'post')) ?: NULL;
            $contactArray[$post] = ${$post};
        }

        $cs_user_password = (Sanitizer::filter('cs_user_password', 'post')) ?: NULL;

        $stmt = $connection->prepare("SELECT cs_user_password FROM cs_users WHERE cs_user_id = '$__user_id'");
        $stmt->execute();
        $result = $stmt->get_result()->fetch_row();
        $stmt->close();

        if(!password_verify($cs_user_password, $result[0])){
            echo json_encode(array('code' => 0, 'message' => 'Your password is incorrect. Failed to authenticate.'));
            die();
        }

        $contactArrayToDB = serialize($contactArray);

        if(!$user->updateUserCol($__user_id, 'cs_contact_details', 's', $contactArrayToDB)){
            echo json_encode(array('code' => 0, 'message' => 'Failed to update your contact details.'));
            die();
        }


        $message = json_encode(array('code' => 1, 'message' => 'Contact Details updated'));
        break;

    case 'rate':
        $to = Sanitizer::filter('to', 'get');
        $from = $__user_id;
        $message = $user->getRating($from, $to);
        break;

    case 'rate-insert':
        $to = Sanitizer::filter('to', 'get');
        $rate = Sanitizer::filter('rate', 'post', 'int');
        if($rate > 5) { $rate = 5; }
        if($rate <= 0) { $rate = 0; }
        $comment = Sanitizer::filter('comment', 'post');
        $from = $__user_id;
        $message = $user->postRating($from, $to, $rate, $comment);
        break;

    case 'rate-update':
        /* $to = Sanitizer::filter('to', 'get');
        $rate = Sanitizer::filter('rate', 'post', 'int');
        if($rate > 5) { $rate = 5; }
        if($rate <= 0) { $rate = 0; }
        $comment = Sanitizer::filter('comment', 'post');
        $from = $__user_id;
        $message = $user->updateRating($from, $to, $rate, $comment); */
        $message = json_encode(array('code' => 1, 'message' => 'Updating ratings are disabled'));
        break;

    case 'view':

        $selector = Sanitizer::filter('selector', 'get');
        $stmt = $connection->prepare("SELECT cs_user_name, cs_user_role FROM cs_users WHERE cs_user_id = ? OR cs_user_name = ? LIMIT 1");
        $stmt->bind_param('is', $selector, $selector);
        $stmt->execute();
        $role = $stmt->get_result()->fetch_row();
        $stmt->close();

        if(empty($role)) {
            echo json_encode(array('code' => 0, 'message' => 'user not found'));
            die();
        }

        switch($role[1]){
            case '1':
                $message = json_encode(array('code' => 1, 'path' => 'user', 'selector' => $role[0]));
                break;
            case '2':
                $stmt = $connection->prepare("SELECT cs_business_link FROM cs_business WHERE cs_user_id = ?");
                $stmt->bind_param('i', $selector);
                $stmt->execute();
                $link = $stmt->get_result()->fetch_row();
                $stmt->close();

                if(empty($link)){    
                    $message = json_encode(array('code' => 1, 'path' => 'user', 'selector' => $role[0]));
                } else {
                    $message = json_encode(array('code' => 1, 'path' => 'supplier', 'selector' => $link[0]));
                }
        }
    
        break;
}

echo $message;