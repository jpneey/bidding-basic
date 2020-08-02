<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0"/>
  <title><?php echo $pageTitle ?></title>

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
            $selector = Sanitizer::filter($uri[1], 'var');
            if(!$selector){
              require 'component/empty.php';
            } else {
              $viewBids->load($viewBids->viewBid($selector));
              $viewOffers->load($viewOffers->viewOfferForm($bid->getBid($selector, 'cs_bidding_id'), $isSupplier, $__user_id));
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