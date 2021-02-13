<?php 

require_once "../controller.auth.php";
require_once "../controller.sanitizer.php";
require_once "../controller.db.php";
require_once "../../model/model.payment.php";


$auth = new Auth();
$db = new DBHandler();
$connection = $db->connectDB();
$payment = new Payment();

$mode = Sanitizer::filter('mode', 'get');


$isLoggedIn = $auth->getSession('admin_auth');
if(!$isLoggedIn) { die();}

switch($mode) {

        
    case 'update':

        $uid = Sanitizer::filter('uid', 'get', 'int');
        $tid = Sanitizer::filter('tid', 'get', 'int');
        $val = Sanitizer::filter('val', 'get', 'int');

        if($val == "1"){
            if($payment->hasActivePlan($uid, true)){
                echo json_encode(array('code' => 0, 'message' => 'It seems like there are active / or pending plans on this account.<br>Upgrade to pro requests are only limited to 1 pending/active request per account.'));
                die();
            }
            $payment->toNotif("Your account was upgraded to PRO!", "my/plan/", $uid);
        }

        if($val == "2"){
            $payment->toNotif("Your PRO plan expired :(", "my/plan/", $uid);
        }

        if(empty($val)){
            $payment->toNotif("Your PRO plan status was reverted back to processing.", "my/plan/", $uid);
        }

        if($val == "3"){
            $payment->deletePayment($uid, $tid);
        }

        $payment->updateStatus($uid, $tid, $val);

        $code = 2;
        $message = "Account Updated ";
        break;

    case 'new':

        $uid = Sanitizer::filter('uid', 'get', 'int');
        $tid = Sanitizer::filter('tid', 'get', 'int');
        $val = Sanitizer::filter('val', 'get', 'int');

        if($payment->hasActivePlan($uid)){
            echo json_encode(array('code' => 0, 'message' => 'It seems like there are active / or pending plans on this account.<br>Upgrade to pro requests are only limited to 1 pending/active request per account.'));
            die();
        }

        $payment->toNotif("Your account was upgraded to PRO!", "my/plan/", $uid);

        $payment->toPro($uid, $tid, $val);

        $code = 2;
        $message = "Account Updated to PRO";
        break;

    case 'free':

        $uid = Sanitizer::filter('uid', 'get', 'int');
        $tid = Sanitizer::filter('tid', 'get', 'int');
        $val = Sanitizer::filter('val', 'get', 'int');

        $payment->toNotif("Your PRO plan expired :(", "my/plan/", $uid);

        $payment->toFree($uid, $tid, $val);

        $code = 2;
        $message = "Account Updated ";
        break;

    default:
        $code = 0;
        $message = "Bad Request";
}


echo json_encode(array('code' => $code, 'message' => $message));
