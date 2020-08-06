<?php

defined('included') || die("Bad request");

$dashboardAction = Sanitizer::filter('action', 'get');

if($isBidder) {
    switch($dashboardAction){
        case 'add':
            require 'component/my/dashboard.add.php';
            break;

        default:
            echo '<div class="col s12"><p><b>My Posts</b></p></div>';
            require_once "model/model.bids.php";
            require_once "view/view.bids.php";
            $viewBids = new viewBids($BASE_DIR);
            $viewBids->load($viewBids->viewUserBidStatus($__user_id));
            $viewBids->load($viewBids->viewUserBids($__user_id));
            break;
    }
}

if($isSupplier) {
    echo '<div class="col s12"><p><b>My Offers</b></p></div>';
    require_once "model/model.offers.php";
    require_once "view/view.offers.php";
    $viewOffers = new viewOffers($BASE_DIR);
    $viewOffers->load($viewOffers->viewUserOfferStatus($__user_id));
    $viewOffers->load($viewOffers->viewUserOffers($__user_id));

}
?>
<script src="<?php echo $BASE_DIR ?>static/js/services/services.delete.js" type="text/javascript"></script>