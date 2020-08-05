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
        <div class="col s12 m9">
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
              require 'component/empty.php';
            } else {
              $viewBids->load($viewBids->viewBid($selector));
              $viewOffers->load($viewOffers->viewOfferForm($bid->getBid($selector, 'cs_bidding_id'), $isSupplier, $__user_id));
              $bidOwner = $bid->checkOwnership($selector, $__user_id);
            if($isLoggedIn && $isBidder && $bidOwner) {
              ?>
              <div class="fixed-action-btn">
                <a class="btn-floating btn-large orange pulse">
                  <i class="large material-icons">mode_edit</i>
                </a>
                <ul>
                  <li><a class="btn-floating red"><i class="material-icons">delete</i></a></li>
                  <li><a class="btn-floating green darken-1"><i class="material-icons">mode_edit</i></a></li>
                </ul>
              </div>
            <?php    
              }
            }
          ?>
        </div>
        
        <div class="col s12 m3 hide-on-med-and-down">

          <ul class="section table-of-contents pushpin">
            <li><a href="#introduction">At a glance</a></li>
            <li><a href="#bidding-details">Bidding details</a></li>
            <li><a href="#submit-offer">Submit offer</a></li>
          </ul>

        </div>
      </div>
    </div>
  </div>

  <script src="<?php echo $BASE_DIR ?>static/js/services/services.feed.js" type="text/javascript"></script>
  <?php
    require "./component/footer.php";
  ?>