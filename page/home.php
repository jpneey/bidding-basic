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
        <div class="col s12 m8">
          <?php
            require "view/view.feed.php";
          ?>
        </div>
        <div class="col s12 m4">
     
          <div class="chip z-depth-1 white">
            The New Lorem
            <i class="close material-icons">close</i>
          </div>
          <div class="chip z-depth-1 white">
           Blue
            <i class="close material-icons">close</i>
          </div>
          <div class="chip z-depth-1 white">
           Sky
            <i class="close material-icons">close</i>
          </div>
          <div class="chip z-depth-1 white">
           Connectitur
            <i class="close material-icons">close</i>
          </div>
          <div class="chip z-depth-1 white">
            Elipsis Dotor
            <i class="close material-icons">close</i>
          </div>
      
        </div>
      </div>
    </div>
  </div>
  <?php
    require "./component/footer.php";
  ?>