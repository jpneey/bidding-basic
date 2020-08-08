<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0"/>
  <title><?php echo 'Canvasspoint - 404' ?></title>
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
        <div class="col s12">
          <?php 
            
            $emptyTitle = "Ah yes, 404";
            $emptyMessage = "It seems like the page you are looking for was moved, deleted or didn't exist at all.";
            require_once "component/empty.php";
          ?>
        </div>

      </div>
    </div>
  </div>
  <?php
    require "./component/footer.php";
  ?>