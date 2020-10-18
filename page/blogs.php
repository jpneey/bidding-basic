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
        <div class="col s12 m12" id="bidding-feed">
          <div class="feed-wrap-main">
            <?php 
            $search = new Search($BASE_DIR, 'blog');
            $search->searchForm(true, 2);

            require_once "model/model.blog.php";
            require_once "view/view.blog.php";
            $blog = new Blogs();
            $viewBlogs = new viewBlogs($BASE_DIR);
            $viewBlogs->viewBlogs(array(), "Active Biddings will go here but unfortunately there are no active biddings as of the moment. How about viewing our suppliers ?", $loggedInUserRole);
            ?>
          </div>
        </div>
        <div class="col s12 m3 feed-sidebar hide-on-med-and-down">
          <div class="search-bar">
            
          
          </div>
        </div>

      </div>
    </div>
  </div>
  <script src="<?= $BASE_DIR ?>static/js/services/services.feed.js?v=beta-199"></script>
  <?php
    require "./component/footer.php";
  ?>