<?php

require_once "./controller.sanitizer.php";
require_once "./controller.database.php";
require_once "./controller.auth.php";
require_once "../model/model.notification.php";


$auth = new Auth();
$dbhandler = new DBHandler();
$conn = $dbhandler->connectDB();
$__user_id = (int)$auth->getSession('__user_id');

$notification = new Notification($__user_id, $conn);
$mode = Sanitizer::filter('mode', 'get', 'int');


switch($mode){
    case "1":
        $response = '';
        ?>
        <li class="navbar-fixed"></li>
        <li class="white">
            <a class="waves-effect mark-as-read delete-all-read"><i class="material-icons left">notes</i><b>Delete all read</b></a>
        </li>
        
        <li class="notif-panel">
        <?php 
        $unreadNotifs = $notification->getUnread(false);
        if(!empty($unreadNotifs)) {
            foreach($unreadNotifs as $key=>$value){ ?>
            <span class="mark-this-read" data-del="<?= $unreadNotifs[$key]['cs_notif_id'] ?>" ><?= $unreadNotifs[$key]['cs_notif'] ?><br>
                <time class="timeago" datetime="<?= $unreadNotifs[$key]['cs_added'] ?>" title="<?= $unreadNotifs[$key]['cs_added'] ?>"><?= $unreadNotifs[$key]['cs_added'] ?></time>
            </span>
        <?php }
        } ?>
        </li>
        <li class="notif-panel read">
        <?php 
        $readNotifs = $notification->getRead(false);
        if(!empty($readNotifs)) {
            foreach($readNotifs as $key=>$value){ ?>
            <span><?= $readNotifs[$key]['cs_notif'] ?><br>
                <time class="timeago" datetime="<?= $readNotifs[$key]['cs_added'] ?>" title="<?= $readNotifs[$key]['cs_added'] ?>"><?= $readNotifs[$key]['cs_added'] ?></time>
            </span>
        <?php }
        } ?>
        </li>
        <?php
        break;

    case "2":
        $email = Sanitizer::filter('email', 'post');
        $message = Sanitizer::filter('message', 'post');

        require_once "../model/model.user.php";
        $user = new User($conn);

        $user->sendMail("Feature my product", "Someone contacted us from Canvasspoint blogs", "Message from Canvasspoint Blogs:", $message, "mailto:$email", "$email", "", "", false);
        $response = "Thanks for reaching out! We'll get back to you soon!";
        break;
    
    default:
        $response = $notification->getUnread();
        break;
}

echo $response;