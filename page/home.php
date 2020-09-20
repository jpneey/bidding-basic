<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0"/>
  <title><?php echo 'Canvasspoint - '. ucfirst($pageTitle); ?></title>

  <?php
    require "component/head.php";
  ?>
  <link href="<?= $BASE_DIR ?>static/css/feed.css?v=beta-sxx2" type="text/css" rel="stylesheet"/>

</head>
<body>

  <?php
    require "component/navbar.php";
  ?>
  <div class="main">
    <div class="wrapper wrapper-top-bottom">
      <div class="container row">
        <div class="col s12 m9" id="bidding-feed">
            <?php 
            $search->searchForm(true);
            if($isBidder) { ?>
  
            <div class="post-card white z-depth-0 waves-effect">    
              <div class="title grey-text text-darken-3"><b>Canvasspoint</b></div>
              <div class="sub-title grey-text">Post your requirement And suppliers will make a bid/offer for it.</div>
              <div class="sub-title">
                  <p>
                    <a href="<?= $BASE_DIR ?>my/dashboard/?action=add" class="btn btn-small orange white-text z-depth-0">Post <i class="material-icons right">add</i></a>
                    <a href="<?= $BASE_DIR ?>my/dashboard/" class="btn btn-small orange darken-2 white-text z-depth-0">Dashboard</a>
                  </p>
              </div>
              
              <div class="image-wrapper"></div>
            </div>
            <?php }          
            require_once "model/model.bids.php";
            require_once "view/view.bids.php";
            $bid = new Bids();
            $viewBids = new viewBids($BASE_DIR);
            $viewBids->viewFeed(array(), "Active Biddings will go here but unfortunately there are no active biddings as of the moment. How about viewing our suppliers ?", $loggedInUserRole);
            
          ?>
        </div>
        <div class="col s12 m3 feed-sidebar hide-on-med-and-down">
          <div class="search-bar">
            <?php  
            $viewBids->viewSideBar($loggedInUserRole);
            ?>
          </div>
        </div>

      </div>
    </div>
  </div>
  <script src="<?= $BASE_DIR ?>static/js/services/services.feed.js?v=beta-199"></script>
  <?php
    require "./component/footer.php";
  ?>