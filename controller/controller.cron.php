<?php

error_reporting(E_ALL);

require_once "./controller.sanitizer.php";
require_once "./controller.database.php";

$dbhandler = new DBHandler();
$conn = $dbhandler->connectDB();

$connection = $dbhandler->connectDB();

$message = "";
$expired_bid = 0;
$espired_plan = 0;
$notified_expired = 0;

date_default_timezone_set('Asia/Manila');

/* check expired biddings */

$currentDateTime = date('Y-m-d');
$currentDateTimeStamp = date('Y-m-d H:i:s');
$nextWeekTimeStamp = date('Y-m-d H:i:s', strtotime('+1 Week'));

$stmt = $connection->prepare("UPDATE cs_biddings SET cs_bidding_status = '0' WHERE DATE(cs_bidding_date_needed) <= '$currentDateTime' AND cs_bidding_status = '1'");
$stmt->execute();
$stmt->close();

$stmt = $connection->prepare("SELECT cs_bidding_user_id, cs_bidding_title, cs_bidding_permalink FROM cs_biddings WHERE cs_bidding_status = 0 AND cs_expired_notif = 0");
$stmt->execute();
$toNotif = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
$stmt->close();

if(!empty($toNotif)){
    $list = array();
    foreach($toNotif as $key=>$value){
        $id = $toNotif[$key]["cs_bidding_user_id"];
        $list[] = $id;
        $link = $toNotif[$key]['cs_bidding_permalink'];
        $notification = "Bidding: <a data-to=\"bid/$link\"><b>".$toNotif[$key]["cs_bidding_title"] . "</b></a> has expired.";
        $stmt = $connection->prepare("INSERT INTO cs_notifications(cs_notif, cs_user_id, cs_added) VALUES('$notification', '$id', '$currentDateTimeStamp')");
        $stmt->execute();
        $stmt->close();
        $expired_bid++;
    }

    $stmt = $connection->prepare("UPDATE cs_biddings SET cs_expired_notif = 1 WHERE cs_bidding_user_id IN (".implode(',', $list).")");
    $stmt->execute();
    $stmt->close();
}

$message .= $expired_bid ." bidding was updated to expired.";

/* check expired plans */

$stmt = $connection->prepare("SELECT cs_plan_id, cs_user_id FROM cs_plans WHERE cs_plan_status = 1 AND DATE(expires) <= '$currentDateTime'");
$stmt->execute();
$toNotif = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
$stmt->close();

if(!empty($toNotif)){
    $list = array();
    foreach($toNotif as $key=>$value){
        $id = $toNotif[$key]["cs_user_id"];
        $plan_id = $toNotif[$key]["cs_plan_id"];
        $list[] = $plan_id;
        $notification = "Bidding: <a data-to=\"my/plan\"><b>Your premium plan</b></a> has expired.";
        $stmt = $connection->prepare("INSERT INTO cs_notifications(cs_notif, cs_user_id, cs_added) VALUES('$notification', '$id', '$currentDateTimeStamp')");
        $stmt->execute();
        $stmt->close();
        $espired_plan++;
    }

    $stmt = $connection->prepare("UPDATE cs_plans SET cs_plan_status = 2 WHERE cs_plan_id IN (".implode(',', $list).")");
    $stmt->execute();
    $stmt->close();
}

$message .= $espired_plan ." plan expired.";

/* Notify users with expiring plans in a week */

$stmt = $connection->prepare("SELECT cs_plan_id, cs_user_id, expires FROM cs_plans WHERE cs_plan_status = 1 AND cs_gateway_comment != 'expiring' AND DATE(expires) <= '$nextWeekTimeStamp'");
$stmt->execute();
$toNotif = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
$stmt->close();

if(!empty($toNotif)){
    $list = array();
    foreach($toNotif as $key=>$value){
        $id = $toNotif[$key]["cs_user_id"];
        $plan_id = $toNotif[$key]["cs_plan_id"];
        $expires =  date('l jS F Y', strtotime($toNotif[$key]["expires"]));
        $list[] = $plan_id;
        $notification = "<a data-to=\"my/plan\">Your premium plan will expire on <b>$expires</b></a>";
        $stmt = $connection->prepare("INSERT INTO cs_notifications(cs_notif, cs_user_id, cs_added) VALUES('$notification', '$id', '$currentDateTimeStamp')");
        $stmt->execute();
        $stmt->close();
        $notified_expired++;
    }

    $stmt = $connection->prepare("UPDATE cs_plans SET cs_gateway_comment = 'expiring' WHERE cs_plan_id IN (".implode(',', $list).")");
    $stmt->execute();
    $stmt->close();

    $message .= $notified_expired ." plans to expired.";

}


echo $message;