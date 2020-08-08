<?php 

$selector = Sanitizer::filter($uri[1], 'var');

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0"/>
  <title>Canvasspoint - <?php echo str_replace('-', ' ', $selector) ?></title>

  <?php
    require "component/head.php";
  ?>

</head>
<body class="minimal">

  <?php
    require "component/navbar.php";
  ?>
  <div class="main">
    <div class="wrapper wrapper-top-bottom">
      <div class="row">
        <div class="col s12">
          <?php

            require_once "model/model.bids.php";
            require_once "view/view.bids.php";
            require_once "model/model.offers.php";
            require_once "view/view.offers.php";
            require_once "controller/controller.sanitizer.php";

            $bid = new Bids();
            $offer = new Offers();
            $viewBids = new viewBids($BASE_DIR);
            $viewOffers = new viewOffers($BASE_DIR);
            if(!$selector){
              $emptyTitle = "Ah yes, 404";
              $emptyMessage = "It seems like the page you are looking for was moved, deleted or didn't exist at all.";
              require_once "component/empty.php";
            } else {
              $viewBids->viewBid($selector);
              $viewOffers->viewOfferForm($bid->getBid($selector, 'cs_bidding_id'), $isSupplier, $__user_id);
              if($isLoggedIn && $isBidder && $bid->checkOwnership($selector, $__user_id)) {
                ?>
                <div class="fixed-action-btn">
                  <a class="btn-floating btn-large orange pulse">
                    <i class="large material-icons">mode_edit</i>
                  </a>
                  <ul>
                    <li><a class="btn-floating red data-delete" data-selector="<?= $selector ?>" data-mode="bid"><i class="material-icons">delete</i></a></li>
                    <li><a class="btn-floating green darken-1"><i class="material-icons">mode_edit</i></a></li>
                  </ul>
                </div>
                <script src="<?php echo $BASE_DIR ?>static/js/services/services.delete.js" type="text/javascript"></script>
                <?php    
              }
            }
          ?>
        </div>
        
      </div>
    </div>
  </div>

  <script src="<?php echo $BASE_DIR ?>static/js/services/services.feed.js" type="text/javascript"></script>
  <?php
    require "./component/footer.php";
  ?>