<?php

$s_options = array('queue', 'category', 'location', 'mode');
foreach($s_options as $options){ ${'s_'.$options} = Sanitizer::filter($options, 'get'); }

$s_mode = ($s_mode) ? $s_mode : 'bid';

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0"/>
  <title><?php echo 'Canvasspoint - '. ucfirst($pageTitle); ?></title>

  <?php
    require "component/head.php";
  ?>
  <link href="<?= $BASE_DIR ?>static/css/feed.css" type="text/css" rel="stylesheet"/>

</head>
<body>

  <?php
    require "component/navbar.php";
  ?>
  <div class="main">
    <div class="wrapper wrapper-top-bottom">
      <div class="container row">
            <?php
                require_once "view/view.search.php";
                $search = new Search($BASE_DIR, 'bid');
                $search->load($search->searchForm(true));
            ?>
        <div class="col s12">
          <?php
          
            switch($s_mode){
                case 'blog':
                    break;
                case 'supplier':
                
                    break;
                case 'bid':
                default:
                  require_once "controller/controller.search.php";
                  require_once "model/model.bids.php";
                  require_once "view/view.bids.php";
                  $bid = new Bids();
                  $controllerSearch = new controllerSearch();
                  $filter = $controllerSearch->searchBid($s_queue, $s_location, $s_category);
                  $viewBids = new viewBids($BASE_DIR);
                  $viewBids->load($viewBids->viewFeed($filter[0], $filter[1], $filter[2]));  
                  break;
            }

          ?>
        </div>

      </div>
    </div>
  </div>
  <script src="<?= $BASE_DIR ?>static/js/services/services.feed.js"></script>
  <?php
    require "./component/footer.php";
  ?>