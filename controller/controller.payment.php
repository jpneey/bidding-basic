<?php

require_once "./controller.auth.php";
require_once "./controller.sanitizer.php";
require_once "./controller.database.php";
require_once "./controller.filevalidator.php";
require_once "../model/model.user.php";
require_once "../model/model.constant.php";

$auth = new Auth();
$dbhandler = new DBHandler();
$conn = $dbhandler->connectDB();
$user = new User($conn);

$connection = $dbhandler->connectDB();
$action = Sanitizer::filter('action', 'get');

if(!$auth->compareSession('auth', true)){
    echo json_encode(array('code' => 0, 'message' => 'Oh no! You need to login to perform this action.'));
    die();
}

$__user_id = (int)$auth->getSession('__user_id');
$__user_role = (int)$auth->getSession('__user_role');

switch ($action) {

    case "cli-pro":
        $message = json_encode(array('code' => 1, 'path' => 'Request Success. Please wait while we are processing your order'));
        
        $kind = "client";
        if($__user_role != 1){ $kind = "supplier"; }


        if($user->hasActivePlan($__user_id)){
            echo json_encode(array('code' => 0, 'message' => 'It seems like there are active / or pending plans on your account.<br>Upgrade to pro requests are only limited to 1 pending/active request per account.'));
            die();
        }

        $order_id = $user->requestUpgrade($kind, $__user_id, false, true);
        $baselink = Sanitizer::getUrl();

        $user->sendMail(
            "#CNPPRO".$order_id." - Canvasspoint PRO application", 
            "Someone requested an account upgrade via Direct Pay",
            "Hello there, ",
            "Someone requested an account upgrade via Direct Pay. Please visit the administration dashboard to get in touch with the customer",
            $baselink."admin/", 
            "Admin Dashboard",
            "This is a system generated email.",
            "- Canvasspoint" 
        );

        $message = json_encode(array('code' => 1, 'message' => 'Request Success. Please wait while we are processing your order', 'order_id' => $order_id));
        
        break;
    
    case "cli-paypal":

        $or = Sanitizer::filter('or', 'get');
        $nm = Sanitizer::filter('nm', 'get');
        $em = Sanitizer::filter('em', 'get');
        
        $note = "Payer name: " . $nm . "\r\n, Email: " . $em;

        $type = 'paypal-client';

        if($__user_role != 1){
            $type = 'paypal-supplier';
        }

        if($user->hasActivePlan($__user_id)){
            echo json_encode(array('code' => 0, 'message' => 'It seems like there are active / or pending plans on your account.<br>Upgrade to pro requests are only limited to 1 pending/active request per account.'));
            die();
        }

        $order_id = $user->requestUpgrade($type, $__user_id, $note, true);
        $baselink = Sanitizer::getUrl();

        $user->sendMail(
            "#CNPPRO".$order_id." - Canvasspoint PRO application", 
            "Someone requested an account upgrade via Paypal",
            "Hello there, ",
            "Someone requested an account upgrade via Paypal. Please visit the administration dashboard to get in touch with the customer",
            $baselink."admin/", 
            "Admin Dashboard",
            "This is a system generated email.",
            "- Canvasspoint" 
        );

        $message = json_encode(array('code' => 1, 'message' => 'Paypal Transaction Success. Please wait while we are processing your order', 'order_id' => $order_id));
        
    break;
}

echo $message;