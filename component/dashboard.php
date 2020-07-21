<?php

defined('included') || die("Bad request");

$dashboardAction = Sanitizer::filter('action', 'get');

if($isBidder) {
    switch($dashboardAction){
        case 'add':
            require 'component/dashboard.add.php';
            break;

        default:
            echo '<p><b>My Posts</b></p>';
            require_once "model/model.bids.php";
            require_once "view/view.bids.php";
            $viewBids = new viewBids($BASE_DIR);
            $viewBids->load($viewBids->viewUserBids($__user_id));
            break;
    }
}