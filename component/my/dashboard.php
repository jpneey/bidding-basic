<?php

defined('included') || die("Bad request");

$dashboardAction = Sanitizer::filter('action', 'get');


$message = Sanitizer::filter('p', 'get');

$newUser = (empty($loggedInUserRole)) ? true : false;
$loggedInUserDetail = $user->getUser($__user_id, "cs_user_detail");

ob_start(); ?>
<div class="col s12 white page z-depth-0" style="z-index: 45">
    <div class="row" style="margin-top: 25px">
        <div class="col s12">
            <div class="row">
                <div class="col s12">
                    <a class="dashboard-show btn white black-text" style="border: 2px dashed #999" data-target="#main-dashboard"><b>My Dashboard</b></a>
                    <a class="dashboard-show btn white black-text" data-target="#transaction-dashboard"><b>Transaction History</b></a>
                </div>
            </div>
        </div>
    </div>
</div>
<div data-target="#transaction-dashboard" id="main-dashboard">
<?php $nav = ob_get_clean(); ?>

<?php
if($isBidder) {
    switch($dashboardAction){
        case 'add':
            require 'component/my/dashboard.add.php';
            break;

        default:
            echo $nav;
            require_once "model/model.bids.php";
            require_once "view/view.bids.php";
            $viewBids = new viewBids($BASE_DIR, $conn);
            $viewBids->viewUserBidStatus($__user_id);

            $viewBids->viewUserBids($__user_id, 1);
            $viewBids->viewUserBids($__user_id, 0);
            $viewBids->viewUserBids($__user_id, 2);
            break;
    }
}

if($isSupplier) {
    echo $nav;
    require_once "model/model.offers.php";
    require_once "view/view.offers.php";
    $viewOffers = new viewOffers($BASE_DIR, $conn);
    $viewOffers->viewUserOfferStatus($__user_id);
    
    $viewOffers->viewUserOffers($__user_id, 1);
    $viewOffers->viewUserOffers($__user_id, 0);
    $viewOffers->viewUserOffers($__user_id, 2);

}

echo '</div>';

require_once "transactions.php";
?>
<script src="<?= $BASE_DIR ?>static/js/services/services.feed.js?v=22" type="text/javascript"></script>
<script src="<?= $BASE_DIR ?>static/js/services/services.delete.js" type="text/javascript"></script>
<script src="<?= $BASE_DIR ?>static/js/services/services.pagidash.js" type="text/javascript"></script>