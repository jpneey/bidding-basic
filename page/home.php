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
<body>

  <?php
    require "component/navbar.php";
  ?>
  <div class="main">
    <div class="wrapper wrapper-top-bottom">
      <div class="container row">
        <div class="col s12 m12">
          <?php
          error_reporting(E_ALL);
            require "view/view.feed.php";
          ?>
        </div>
      </div>
    </div>
  </div>
    
  <script src="<?php echo $BASE_DIR ?>static/js/services/services.login.js" type="text/javascript"></script>
  <?php
    require "./component/footer.php";
  ?>

