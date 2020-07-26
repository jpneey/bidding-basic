<?php

defined('included') || die("Bad request");

$dashboardAction = Sanitizer::filter('action', 'get');

if($isBidder) {
    switch($dashboardAction){
        case 'add':
            require 'component/dashboard.add.php';
            break;

        default:
            echo '<div class="col s12"><p><b>My Posts</b></p></div>';
            require_once "model/model.bids.php";
            require_once "view/view.bids.php";
            $viewBids = new viewBids($BASE_DIR);
            $viewBids->load($viewBids->viewUserOfferStatus($__user_id));
            $viewBids->load($viewBids->viewUserBids($__user_id));
            break;
    }
}

if($isSupplier) {
    
    echo '<p><b>My Offers</b></p>';
    require_once "model/model.offers.php";
    require_once "view/view.offers.php";
    $viewOffers = new viewOffers($BASE_DIR);
    $viewOffers->load($viewOffers->viewUserOffers($__user_id));

}