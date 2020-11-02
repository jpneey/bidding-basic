<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0"/>
  <title>Canvasspoint - Products</title>

  <?php
    require "component/head.php";
  ?>
  <link href="<?= $BASE_DIR ?>static/css/feed.css?v=beta-2.1" type="text/css" rel="stylesheet"/>

</head>
<body class="minimal un-pad-stars">

  <?php
    require "component/navbar.php";
  ?>
  <div class="main">
    <div class="wrapper wrapper-top-bottom">
      <div class="container row">
        <div class="col s12" id="bidding-feed">
          <div class="feed-wrap-main">
          <?php
            $search->searchForm(true);

            require_once "model/model.supplier.php";
            require_once "view/view.supplier.php";
            $supplier = new Supplier();
            $viewSupplier = new viewSupplier($BASE_DIR);
            $viewSupplier->viewFeed();  
          
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