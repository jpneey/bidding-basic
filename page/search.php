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
  <link href="<?= $BASE_DIR ?>static/css/feed.css?v=beta-1ads" type="text/css" rel="stylesheet"/>

</head>
<body>

  <?php
    require "component/navbar.php";
  ?>
  <div class="main">
    <div class="wrapper wrapper-top-bottom">
      <div class="container row">  
        <div class="col s12" id="bidding-feed">
          <div class="feed-wrap-main">
          <?php

                      
            require_once "model/model.bids.php";
            require_once "view/view.bids.php";
            $bid = new Bids($conn);
            $viewBids = new viewBids($BASE_DIR);
          
            require_once "view/view.search.php";
          
            switch($s_mode){
                case 'blog':

                        
                  $search = new Search($BASE_DIR, 'blog');
                  $search->searchForm(true);

                  require_once "controller/controller.search.php";
                  require_once "model/model.blog.php";
                  require_once "view/view.blog.php";

                  $blog = new Blogs();
                  $controllerSearch = new controllerSearch();
                  $filter = $controllerSearch->searchBlog($s_queue, $s_location, $s_category);
                  $viewBlogs = new viewBlogs($BASE_DIR);
                  $viewBlogs->viewBlogs($filter, "There are no active biddings that matches your search criteria.<br>How about viewing our suppliers ?");  
                  
                  break;
                case 'product':
    
                  $search = new Search($BASE_DIR, 'product');
                  $search->searchForm(true);

                  require_once "controller/controller.search.php";
                  require_once "model/model.supplier.php";
                  require_once "view/view.supplier.php";
                  $controllerSearch = new controllerSearch();

                  $filter = $controllerSearch->searchProduct($s_queue, $s_location, $s_category);

                  $viewSupplier = new viewSupplier($BASE_DIR, $conn);
                  $viewSupplier->viewFeed($filter);

                  break;
                case 'bid':
                default:

                  $search = new Search($BASE_DIR, 'bid');
                  $search->searchForm(true);
                  require_once "controller/controller.search.php";
                  $controllerSearch = new controllerSearch();
                  $filter = $controllerSearch->searchBid($s_queue, $s_location, $s_category);
                  $viewBids->viewFeed($filter, "There are no active biddings that matches your search criteria.<br>How about viewing our suppliers ?");  
                  break;
            }

          ?>
          </div>
        </div>

      </div>
    </div>
  </div>
  <script src="<?= $BASE_DIR ?>static/js/services/services.feed.js"></script>
  <?php
    require "./component/footer.php";
  ?>