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
          
            switch(Sanitizer::filter('unauth', 'get')) {
              case '1':
                $messageClass = 'red darken-1 white-text z-depth-1';
                $htmlMessage = 'Unauthorized';
                require 'component/message.php';
                break;
              case '2':
                $messageClass = 'orange white-text z-depth-1';
                $htmlMessage = 'You are now logged out';
                require 'component/message.php';
                break;
            }

            require_once "model/model.bids.php";
            require_once "view/view.bids.php";
            $bid = new Bids();
            $viewBids = new viewBids($BASE_DIR);
            $viewBids->load($viewBids->viewFeed());  
            
          ?>
        </div>
        <div class="col s12 m4">
     
          
          
      
        </div>
      </div>
    </div>
  </div>
  <?php
    require "./component/footer.php";
  ?>